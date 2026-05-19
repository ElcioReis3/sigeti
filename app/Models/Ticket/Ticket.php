<?php

namespace App\Models\Ticket;

use App\Core\AbstractModel;
use App\Models\Category;
use App\Models\Department\Department;
use App\Models\Department\UserDepartment;
use App\Models\User;
use PDO;

class Ticket extends AbstractModel
{
    protected string $table = 'tickets';

    protected string $primaryKey = 'id';

    protected array $fillable = [
        "title",
        "description",
        "department_id",
        "category_id",
        "opened_by",
        "assigned_to",
        "status",
        "priority",
        "opened_at",
        "closed_at"
    ];

    protected array $required = [
        "title" => "O campo TÍTULO é obrigatório.",
        "description" => "O campo DESCRIÇÃO é obrigatório.",
        "department_id" => "O campo DEPARTAMENTO é obrigatório.",
        "category_id" => "O campo CATEGORIA é obrigatório.",
        "opened_by" => "O campo SOLICITANTE é obrigatório.",
        "status" => "O campo STATUS é obrigatório.",
        "priority" => "O campo PRIORIDADE é obrigatório."
    ];

    protected bool $timestamps = true;

    protected bool $softDelete = true;

    public const OPEN = "aberto";

    public const IN_PROGRESS = "em_andamento";

    public const WAITING = "aguardando";

    public const RESOLVED = "resolvido";

    public const FINISHED = "finalizado";

    public const ARCHIVED = "arquivado";

    private const STATUS = [
        self::OPEN,
        self::IN_PROGRESS,
        self::WAITING,
        self::RESOLVED,
        self::FINISHED,
        self::ARCHIVED
    ];

    public const LOW = "baixa";

    public const MEAN = "media";

    public const HIGH = "alta";

    private const PRIORITIES = [
        self::LOW,
        self::MEAN,
        self::HIGH
    ];
    
    private const ALLOWED_TRANSITIONS = [
        self::OPEN => [self::IN_PROGRESS, self::ARCHIVED],
        self::IN_PROGRESS => [self::WAITING, self::RESOLVED, self::ARCHIVED],
        self::WAITING => [self::IN_PROGRESS, self::ARCHIVED],
        self::RESOLVED => [self::FINISHED],
        self::FINISHED => [self::ARCHIVED],
        self::ARCHIVED => [],
    ];

    public function getId(): int
    {
        return $this->attributes["id"];
    }

    public function setTitle(string $title): void
    {
        $title = trim(strip_tags($title));

        if (strlen($title) < 10) {
            throw new \InvalidArgumentException("O título deve ter pelo menos 10 caracteres!");
        }

        if (strlen($title) > 35) {
            throw new \InvalidArgumentException("O título deve ter no máximo 35 caracteres!");
        }

        $this->attributes["title"] = $title;
    }

    public function getTitle(): string
    {
        return $this->attributes["title"];
    }

    public function setDescription(string $description): void
    {
        $description = trim(strip_tags($description));

        if (strlen($description) < 30) {
            throw new \InvalidArgumentException("A descrição deve ter pelo menos 30 caracteres!");
        }

        $this->attributes["description"] = $description;
    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"];
    }

    public function setDepartmentId(int $departmentId): void
    {
        $this->attributes["department_id"] = $departmentId;
    }

    //TODO alterar método para não retornar null, pois deve ter um departamento vinculado no ticket
    public function getDepartmentId(): ?int
    {
        return $this->attributes["department_id"] ?? null;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->attributes["category_id"] = $categoryId;
    }

    public function getCategoryId(): int
    {
        return $this->attributes["category_id"];
    }

    public function setOpenedBy(int $userId): void
    {
        $this->attributes["opened_by"] = $userId;
    }

    public function getOpenedBy(): int
    {
        return $this->attributes["opened_by"];
    }

    public function setAssignedTo(int $userId): void
    {
        $this->attributes["assigned_to"] = $userId;
    }

    public function getAssignedTo(): ?int
    {
        return $this->attributes["assigned_to"] ?? null;
    }

    public function setStatus(?string $status): void
    {
        $status = $status ?? self::OPEN;

        if (!in_array($status, self::STATUS)) {
            throw new \InvalidArgumentException("O status é inválido");
        }

        $this->attributes["status"] = $status;
    }

    public function getStatus(): string
    {
        return $this->attributes["status"];
    }

    public function setPriority(?string $priority): void
    {
        $priority = $priority ?? self::MEAN;
        if (!in_array($priority, self::PRIORITIES)) {
            throw new \InvalidArgumentException("A prioridade é inválida.");
        }
        $this->attributes["priority"] = $priority;
    }

    public function getPriority(): string
    {
        return $this->attributes["priority"];
    }

    public function setOpenedAt(): void
    {
        $timezone = new \DateTimeZone(APP_TIMEZONE);
        $now = new \DateTimeImmutable("now", $timezone);
        $this->attributes["opened_at"] = $now->format("Y-m-d H:i:s");
    }

    public function getOpenedAt(): string
    {
        return $this->attributes["opened_at"];
    }

    public function setClosedAt(): void
    {
        $timezone = new \DateTimeZone(APP_TIMEZONE);
        $now = new \DateTimeImmutable("now", $timezone);
        $this->attributes["closed_at"] = $now->format("Y-m-d H:i:s");
    }

    public function getClosedAt(): ?string
    {
        return $this->attributes["closed_at"] ?? null;
    }

    public function department(): ?Department
    {
        return $this->getDepartmentId() > 0 ? Department::find($this->getDepartmentId()) : null;
    }

    public function category(): ?Category
    {
        return $this->getCategoryId() > 0 ? Category::find($this->getCategoryId()) : null;
    }

    public function openedBy(): ?User
    {
        return $this->getOpenedBy() > 0 ? User::find($this->getOpenedBy()) : null;
    }

    public function assignedTo(): ?User
    {
        return $this->getAssignedTo() > 0 ? User::find($this->getAssignedTo()) : null;
    }

    public function validateBusinessRules(array $data): ?array
    {
        $errors = [];

        if (!empty($data['category_id']) && !Category::find((int)$data['category_id'])) {
            $errors[] = "Categoria não encontrada ou não existe.";
        }

        if (!empty($data['department_id']) && !Department::find((int)$data['department_id'])) {
            $errors[] = "Departamento não encontrado ou não existe.";
        }

        if (!empty($data['opened_by'])) {
            $openedBy = User::find((int)$data['opened_by']);

            if (!$openedBy) {
                $errors[] = "Usuário não encontrado ou não existe.";
            } else {
                $validDepartmentIds  = [];

                /** @var UserDepartment $link */
                foreach (UserDepartment::linksByUser($openedBy->getId()) ?? [] as $link) {
                    $validDepartmentIds [] = $link->getDepartmentId();
                }

                if (!empty($data['department_id']) && !in_array((int)$data['department_id'], $validDepartmentIds , true)) {
                    $errors[] = "Departamento selecionado não está vinculada ao usuário selecionado.";
                }
            }
        }

        if (!empty($data['assigned_to'])) {
            $assignedTo = User::find((int)$data['assigned_to']);

            if (!$assignedTo) {
                $errors[] = "Técnico não encontrado ou não existe.";
            }
        }

        return $errors;
    }

    public function validateStatusTransition(string $newStatus): array
    {
        $current = $this->getStatus();

        if ($newStatus === $current) {
            return [];
        }

        $allowed = self::ALLOWED_TRANSITIONS[$current] ?? [];

        if (!in_array($newStatus, $allowed, true)) {
            $labels = [
                self::OPEN => "Aberto",
                self::IN_PROGRESS => "Em Andamento",
                self::WAITING => "Aguardando",
                self::RESOLVED => "Resolvido",
                self::FINISHED => "Finalizado",
                self::ARCHIVED => "Arquivado",
            ];

            $currentLabel = $labels[$current] ?? $current;
            $newLabel = $labels[$newStatus] ?? $newStatus;

            return ["Não é permitido alterar o status de '{$currentLabel}' para '{$newLabel}'."];
        }

        return [];
    }

    public function allOrdered(): array
    {
        $sql = "SELECT * FROM {$this->table}
         WHERE deleted_at IS NULL   
         ORDER BY 
                FIELD(status, 'aberto', 'em_andamento', 'aguardando', 'resolvido', 'finalizado', 'arquivado'),
                FIELD(priority, 'alta', 'media', 'baixa'),
                opened_at DESC";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(static fn($row) => static::hydrate($row), $rows);
    }

    public function validateBusinessRulesForTeacher(array $data): array
    {
        $errors = [];

        if (!empty($data["category_id"]) && !Category::find((int)$data["category_id"])) {
            $errors[] = "Categoria não encontrada ou não existe.";
        }

        return $errors;
    }

    public function allOrderedByUser(int $userId): array
    {
        $sql = "SELECT * FROM {$this->table}
            WHERE opened_by = :user_id AND deleted_at IS NULL
            ORDER BY
                FIELD(status, 'aberto', 'em_andamento', 'aguardando', 'resolvido', 'finalizado', 'arquivado'),
                FIELD(priority, 'alta', 'media', 'baixa'),
                opened_at DESC";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_map(static fn($row) => static::hydrate($row), $rows);
    }

    public function existsComments(): bool
    {
        return (new TicketComment())->where("ticket_id", "=", $this->getId())->count() > 0;
    }

    public function countByStatusCurrentYear(): array
    {
        $year = date('Y');

        $sql = "SELECT status, COUNT(*) as total
            FROM {$this->table}
            WHERE deleted_at IS NULL
              AND YEAR(opened_at) = :year
            GROUP BY status";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, \PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $result = [
            self::OPEN => 0,
            self::IN_PROGRESS => 0,
            self::WAITING => 0,
            self::RESOLVED => 0,
            self::FINISHED => 0,
            self::ARCHIVED => 0,
        ];

        foreach ($rows as $row) {
            $result[$row['status']] = (int)$row['total'];
        }

        return $result;
    }

    public function countByMonthCurrentYear(): array
    {
        $year = date('Y');

        $sql = "SELECT MONTH(opened_at) as month, COUNT(*) as total
            FROM {$this->table}
            WHERE deleted_at IS NULL
              AND YEAR(opened_at) = :year
            GROUP BY MONTH(opened_at)
            ORDER BY month ASC";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, \PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $result = array_fill(1, 12, 0);

        foreach ($rows as $row) {
            $result[(int) $row['month']] = (int) $row['total'];
        }

        return array_values($result);
    }

    public function countByCategoryCurrentYear(): array
    {
        $year = date('Y');

        $sql = "
        SELECT c.name AS label, COUNT(t.id) AS total
        FROM tickets t
        JOIN categories c ON c.id = t.category_id
        WHERE YEAR(t.opened_at) = :year
        GROUP BY c.name
        ORDER BY c.name
    ";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $data = [
            'labels' => [],
            'totals' => []
        ];

        if (!empty($result)) {

            foreach ($result as $row) {

                if (isset($row['label'])) {
                    $data['labels'][] = $row['label'];
                } else {
                    $data['labels'][] = 'Sem nome';
                }

                if (isset($row['total'])) {
                    $data['totals'][] = (int) $row['total'];
                } else {
                    $data['totals'][] = 0;
                }
            }

        }

        return $data;
    }

    public function resolutionRateCurrentYear(): int
    {
        $year = date('Y');

        $sql = "SELECT
                COUNT(*) as total,
                SUM(CASE WHEN status IN ('resolvido', 'finalizado') THEN 1 ELSE 0 END) as resolved
            FROM {$this->table}
            WHERE deleted_at IS NULL
              AND YEAR(opened_at) = :year";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, \PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if ((int) $row['total'] === 0) {
            return 0;
        }

        return (int) round(($row['resolved'] / $row['total']) * 100);
    }

    public function countTicketsByStatus(?int $userId = null, ?int $year = null): array
    {
        $year = $year ?? (int)date('Y');

        $sql = "SELECT
                    status AS status,
                    COUNT(*) AS total
                FROM tickets
                WHERE YEAR(opened_at) = :year";

        if($userId){
            $sql .= " AND opened_by = :user_id ";
        }

        $sql .= " GROUP BY status;";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":year", $year, \PDO::PARAM_INT);

        if($userId){
            $statement->bindParam(":user_id", $userId, \PDO::PARAM_INT);
        }

        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $results = [
            self::OPEN => 0,
            self::IN_PROGRESS => 0,
            self::WAITING => 0,
            self::RESOLVED => 0,
            self::FINISHED => 0,
            self::ARCHIVED => 0
        ];

        foreach ($rows as $row) {
            $results[$row['status']] = $row['total'];
        }

        return $results;
    }

    public function countTicketsByMonth(?int $userId = null, ?int $year = null): array
    {
        $year = $year ?? (int)date('Y');

        $sql = "select month(opened_at) as month, count(*) as quantity
                from {$this->table}
                where year(opened_at) = :year";

        if($userId){
            $sql .= " AND opened_by = :user_id ";
        }

        $sql .= " group by month(opened_at) order by month(opened_at);";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":year", $year, \PDO::PARAM_INT);

        if($userId){
            $statement->bindParam(":user_id", $userId, \PDO::PARAM_INT);
        }

        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $results = [];
        for ($count = 1; $count <= 12; $count++) {
            $results[$count] = 0;
        }

        foreach ($rows as $row) {
            $results[$row['month']] = $row['quantity'];
        }

        return array_values($results);

    }

    public function countTicketsByCategory(?int $userId = null, ?int $year = null): array
    {
        $year = $year ?? (int)date('Y');

        $sql = "SELECT  categories.name as label, count(*) as total
                FROM {$this->table}
                INNER JOIN categories ON tickets.category_id = categories.id
                where year(opened_at) = :year";

        if($userId){
            $sql .= " AND opened_by = :user_id ";
        }

        $sql .= " group by categories.name
                order by categories.name;";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":year", $year, \PDO::PARAM_INT);

        if($userId){
            $statement->bindParam(":user_id", $userId, \PDO::PARAM_INT);
        }

        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $results = [
            "labels" => [],
            "totals" => []
        ];

        foreach ($rows as $row) {
            $results["labels"][] = $row['label'];
            $results["totals"][] = $row['total'];
        }

        return $results;
    }

    public function avgResolutionDaysByMonthCurrentYear(?int $year = null): array
    {
        $year = $year ?? (int)date('Y');

        $sql = "SELECT
                MONTH(opened_at) as month,
                ROUND(AVG(DATEDIFF(closed_at, opened_at))) as avg_days
            FROM {$this->table}
            WHERE deleted_at IS NULL
              AND closed_at IS NOT NULL
              AND status IN ('resolvido', 'finalizado')
              AND YEAR(opened_at) = :year
            GROUP BY MONTH(opened_at)
            ORDER BY month ASC";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, \PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $result = array_fill(1, 12, 0);

        foreach ($rows as $row) {
            $result[(int) $row['month']] = (int) $row['avg_days'];
        }

        return array_values($result);
    }

    public function countByPriorityAndStatusCurrentYear(?int $year = null): array
    {
        $year = $year ?? (int)date('Y');

        $sql = "SELECT
                priority,
                status,
                COUNT(*) as total
            FROM {$this->table}
            WHERE deleted_at IS NULL
              AND YEAR(opened_at) = :year
            GROUP BY priority, status
            ORDER BY priority, status";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, \PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $result = [
            self::LOW  => [
                self::OPEN => 0, self::IN_PROGRESS => 0, self::WAITING => 0,
                self::RESOLVED => 0, self::FINISHED => 0, self::ARCHIVED => 0,
            ],
            self::MEAN => [
                self::OPEN => 0, self::IN_PROGRESS => 0, self::WAITING => 0,
                self::RESOLVED => 0, self::FINISHED => 0, self::ARCHIVED => 0,
            ],
            self::HIGH => [
                self::OPEN => 0, self::IN_PROGRESS => 0, self::WAITING => 0,
                self::RESOLVED => 0, self::FINISHED => 0, self::ARCHIVED => 0,
            ],
        ];

        foreach ($rows as $row) {
            $result[$row['priority']][$row['status']] = (int) $row['total'];
        }

        return $result;
    }

    public function ticketsOrderedByStatusPriorityAndOpeningDate(): array
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE deleted_at IS NULL
                ORDER BY 
                    FIELD(status, 'aberto', 'em_andamento', 'aguardando', 'resolvido', 'finalizado', 'arquivado'),
                    FIELD(priority, 'alta', 'media', 'baixa'),
                    opened_at DESC
                    ";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($rows as $row) {
            $results[] = static::hydrate($row);
        }

        return $results;
    }

    public function ticketsOrderedByStatusPriorityAndOpeningDateByUser(int $userId): array
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE opened_by = :opened_by AND deleted_at IS NULL
                ORDER BY 
                    FIELD(status, 'aberto', 'em_andamento', 'aguardando', 'resolvido', 'finalizado', 'arquivado'),
                    FIELD(priority, 'alta', 'media', 'baixa'),
                    opened_at DESC
                    ";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":opened_by", $userId, \PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($rows as $row) {
            $results[] = static::hydrate($row);
        }

        return $results;
    }

    public function totalTicketsOpened(): ?int
    {
        return (new static())
            ->where("status", "=", self::OPEN)
            ->count();
    }
}
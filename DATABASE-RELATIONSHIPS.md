# Database Relationships Documentation

## Overview
This document describes the relationships between tables in the SIMAEL (Sistem Manajemen Pintar PKL) database system.

---

## Table Structure

### 1. **students** Table
Stores information about students in the system.

```sql
CREATE TABLE students (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    nisn VARCHAR(20) UNIQUE,        -- Nomor Induk Siswa Nasional (Student ID)
    major VARCHAR(50),              -- PPLG, TJKT, BCF, DKV
    password VARCHAR(255),
    status VARCHAR(50),             -- verified, pending
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Fields:**
- `id` - Unique identifier (Auto-increment)
- `name` - Student's full name
- `nisn` - Student ID number (Nomor Induk Siswa Nasional) - Used as key in relationships
- `major` - Student's major/course
- `password` - Hashed password for authentication
- `status` - Account verification status

**Note:** No `squad_id` foreign key - Uses denormalized NISN-based design.

---

### 2. **squads** Table
Stores squad/group information with denormalized NISN references.

```sql
CREATE TABLE squads (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) UNIQUE,        -- Squad name (max 20 characters)
    leader_nisn BIGINT,             -- NISN of squad leader
    members_nisn TEXT,              -- Comma-separated NISNs of members
    nama_perusahaan VARCHAR(255),   -- Company name (nullable)
    alamat_perusahaan VARCHAR(255), -- Company address (nullable)
    status ENUM('on-progress', 'diterima', 'pengajuan', 'unknown'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX(leader_nisn),
    INDEX(status)
);
```

**Fields:**
- `id` - Unique identifier (Auto-increment)
- `name` - Squad name (max 20 characters, must be unique)
- `leader_nisn` - NISN of the squad leader (Nomor Induk Siswa Nasional)
- `members_nisn` - Comma-separated list of member NISNs (e.g., "1234567890, 0987654321")
- `nama_perusahaan` - Company name for internship placement
- `alamat_perusahaan` - Company address
- `status` - Squad status (proposal, in-progress, accepted, unknown)

**Design Decision:**
- Uses NISN instead of foreign key IDs for flexibility
- Members stored as CSV string to allow easy addition/removal without extra tables
- No foreign key constraint on students table

---

## Relationships

### A. Student → Squad (One-to-Many)
A student can lead multiple squads and be a member of multiple squads.

#### 1. **leadingSquads** (Student → Squad as Leader)
**One Student → Many Squads (as leader)**

```php
// In Student Model
public function leadingSquads()
{
    return Squad::where('leader_nisn', $this->nisn)->get();
}

// Usage
$student = Student::where('nisn', '1234567890')->first();
$leadsquads = $student->leadingSquads();  // Returns Collection of Squad objects
```

**Database Relationship:**
```
students.nisn → squads.leader_nisn
```

#### 2. **memberSquads** (Student → Squad as Member)
**One Student → Many Squads (as member)**

```php
// In Student Model
public function memberSquads()
{
    $squads = Squad::all();
    return $squads->filter(function ($squad) {
        $memberNisns = array_map('trim', explode(',', $squad->members_nisn ?? ''));
        return in_array($this->nisn, $memberNisns);
    });
}

// Usage
$student = Student::where('nisn', '1234567890')->first();
$memberSquads = $student->memberSquads();  // Returns Collection of Squad objects
```

**Database Relationship:**
```
students.nisn → squads.members_nisn (CSV string)
```

#### 3. **allSquads** (Convenience Method)
**Get all squads a student is associated with (leader or member)**

```php
// In Student Model
public function allSquads()
{
    $leadingSquads = $this->leadingSquads();
    $memberSquads = $this->memberSquads();
    return $leadingSquads->merge($memberSquads);
}

// Usage
$student = Student::where('nisn', '1234567890')->first();
$allSquads = $student->allSquads();  // All squads (as leader or member)
```

---

### B. Squad → Student (One-to-Many)
A squad has one leader and multiple members.

#### 1. **leader()** (Squad → Leader Student)
**One Squad → One Student (Leader)**

```php
// In Squad Model
public function leader()
{
    return Student::where('nisn', $this->leader_nisn)->first();
}

// Usage
$squad = Squad::find(1);
$leader = $squad->leader();  // Returns single Student object
```

**Database Relationship:**
```
squads.leader_nisn → students.nisn
```

#### 2. **members()** (Squad → Member Students)
**One Squad → Many Students (Members)**

```php
// In Squad Model
public function members()
{
    if (empty($this->members_nisn)) {
        return collect();
    }
    
    $nisns = array_map('trim', explode(',', $this->members_nisn));
    return Student::whereIn('nisn', $nisns)->get();
}

// Usage
$squad = Squad::find(1);
$members = $squad->members();  // Returns Collection of Student objects
```

**Database Relationship:**
```
squads.members_nisn (CSV) → students.nisn (multiple matches)
```

#### 3. **memberCount()** (Convenience Method)
**Get count of squad members**

```php
// In Squad Model
public function memberCount()
{
    if (empty($this->members_nisn)) {
        return 0;
    }
    
    $nisns = array_map('trim', explode(',', $this->members_nisn));
    return count(array_filter($nisns));
}

// Usage
$squad = Squad::find(1);
$count = $squad->memberCount();  // Returns integer
```

#### 4. **allMembers()** (Convenience Method)
**Get leader and members as single collection**

```php
// In Squad Model
public function allMembers()
{
    $leader = $this->leader();
    if (!$leader) {
        return collect();
    }
    
    $members = $this->members();
    return collect([$leader])->merge($members);
}

// Usage
$squad = Squad::find(1);
$allMembers = $squad->allMembers();  // Returns Collection with leader + members
```

---

## Relationship Diagram

```
┌─────────────┐                    ┌─────────────┐
│  students   │                    │   squads    │
├─────────────┤                    ├─────────────┤
│ id (PK)     │                    │ id (PK)     │
│ nisn (U)    │◄─────────┬─────────├─leader_nisn │
│ name        │          │         │ members_nisn│ (CSV: nisn1, nisn2, ...)
│ major       │          │         │ name        │
│ password    │          └─────────├─────────────┤
│ status      │                    │ status      │
│ created_at  │                    │ created_at  │
│ updated_at  │                    │ updated_at  │
└─────────────┘                    └─────────────┘

Relationship Types:
1. Student leads Squad (1:N)
   students.nisn → squads.leader_nisn

2. Student in Squad (N:M)
   students.nisn → squads.members_nisn (CSV)
```

---

## Design Rationale: Denormalized NISN-Based Design

### Why NISN instead of ID?
1. **Student Identification:** NISN is a nationally standardized student ID
2. **Portability:** NISN is unique across schools
3. **Business Logic:** Business rules reference NISN, not database ID

### Why CSV for Members instead of Separate Table?
1. **Flexibility:** Easy to add/remove members without schema changes
2. **Simplicity:** No need for junction table
3. **Performance:** Fewer joins required
4. **Scalability:** Typical squad size is small (2-5 members)

### Implications:
- No foreign key constraints
- Data integrity depends on application validation
- Must validate NISN exists in students table before insertion
- Member operations require string parsing

---

## Common Queries

### Find all students in a specific squad
```php
$squad = Squad::find(1);
$allMembers = $squad->allMembers();  // Includes leader
$justMembers = $squad->members();    // Excludes leader
```

### Find squads led by a student
```php
$student = Student::where('nisn', '1234567890')->first();
$leadsquads = $student->leadingSquads();
```

### Find squads a student is member of
```php
$student = Student::where('nisn', '1234567890')->first();
$memberSquads = $student->memberSquads();
```

### Find all squads a student is in (any role)
```php
$student = Student::where('nisn', '1234567890')->first();
$allSquads = $student->allSquads();
```

### Check if student is in a squad
```php
$student = Student::find(1);
$squad = Squad::find(1);

// Check if leader
$isLeader = $squad->leader_nisn == $student->nisn;

// Check if member
$memberNisns = array_map('trim', explode(',', $squad->members_nisn ?? ''));
$isMember = in_array($student->nisn, $memberNisns);

// Check if either
$isInSquad = $isLeader || $isMember;
```

---

## Data Integrity Rules

1. **leader_nisn must exist in students table**
2. **All NISNs in members_nisn must exist in students table**
3. **Leader NISN should not be in members_nisn** (Optional but recommended)
4. **Squad name must be unique**
5. **Squad name max 20 characters**
6. **NISN must be unique in students table**

---

## Migration Status

**Database Structure:**
- ✅ students table created
- ✅ squads table created with NISN-based design
- ❌ No squad_id column in students table (by design)

**Model Relationships:**
- ✅ Student model methods: leadingSquads(), memberSquads(), allSquads()
- ✅ Squad model methods: leader(), members(), memberCount(), allMembers()

---

## Version History

- **v1.0** - November 22, 2025: Initial denormalized NISN-based design
  - Moved from FK-based design (squad_id in students)
  - Uses NISN for relationships
  - CSV storage for squad members

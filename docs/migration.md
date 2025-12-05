# 🐘 Database Management with Doctrine ORM

This section outlines the primary Symfony commands for creating and updating your database schema using **Doctrine ORM** and **Migrations**.

---

## 💾 Migrations

Migrations allow you to track changes to your database structure (schema) as versioned PHP files. This ensures consistency and reproducibility across all environments and development teams.

### 1. ⚙️ Creating or Editing a Table

The process of creating or updating a table involves two main steps: defining the schema in PHP (Entity) and then generating the SQL (Migration).

#### A. Create or Update an Entity

Use the Symfony MakerBundle to generate a new Entity class or interactively add new columns to an existing one.

```bash
# Creates a new entity (e.g., Product) or adds fields to an existing one
php bin/console make:entity TableName
```

#### B. Generate the Migration File

This command compares the current state of your database schema with your updated PHP Entities and generates the necessary SQL into a new PHP migration file (migrations/*.php).

```bash
php bin/console make:migration
```

### 2. 🚀 Applying Migrations
Once you have generated the migration file and reviewed its SQL content, apply the changes to your database.

``` bash
# Applies all pending migrations to the database
php bin/console doctrine:migrations:migrate
```

### 3. Revert Previously Migration
``` bash
php bin/console doctrine:migrations:migrate prev
```
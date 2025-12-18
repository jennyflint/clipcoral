# Using Psalm

### Initialize Configuration
 -  ```bash
     ${workspaceFolder}/vendor/bin/php-cs-fixer 
     ```
### Enable Symfony Plugin
 - ```bash 
    vendor/bin/psalm-plugin enable psalm/plugin-symfony
    ```
### 🛠 Basic Usage
 - ```bash 
    vendor/bin/psalm 
    ```
#### Analyze Specific File or Directory
 - ```bash 
    vendor/bin/psalm src/Controller/SomeController.php 
    ```
 - ```bash 
    vendor/bin/psalm src/Entity 
    ```
#### Clear Cache
 - ```bash 
    vendor/bin/psalm --clear-cache 
    ```
#### Run Security Scan
 - ```bash 
    vendor/bin/psalm --taint-analysis 
    ```
#### Scan Specific File for Vulnerabilities
 - ```bash 
    vendor/bin/psalm src/Controller/SecurityController.php --taint-analysis 
    ```
### Auto Fix
 - ```bash 
    vendor/bin/psalm --alter --issues=MissingReturnType 
    ```
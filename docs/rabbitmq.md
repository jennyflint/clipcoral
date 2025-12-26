# Using Rabbitmq

## Don't forger restart worker after code change

### Run worker in dev
 -  ```bash
     docker compose exec php bin/console messenger:consume async -vv
     ```
### Admin Panel
 - ```web 
    http://localhost:15672
    ```

### Add routing [example]
- ```yaml 
    'App\Message\TestTask': async
    ```
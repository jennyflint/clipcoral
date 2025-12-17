# Using Xdebug

The default development image is shipped with [Xdebug](https://xdebug.org/),
a popular debugger and profiler for PHP.

Because it has a significant performance overhead, the step-by-step debugger
is disabled by default.

1. You need to create a file `xdebug.ini` in the `.docker/php` directory.
2. Add parameters to the ini file an example file can be found in the `.docker/php/xdebug.ini.example` directory.


```
[xdebug]
xdebug.mode=debug,develop
xdebug.start_with_request=yes
xdebug.client_port=9008
xdebug.discover_client_host=1
xdebug.client_host=host.docker.internal
xdebug.log=/tmp/xdebug.log
xdebug.log_level=7
```

3. Run docker command `docker compose down` and `docker compose up -d`

## Debugging with Xdebug and Visual Studio Code

1. Install necessary [PHP extension for Visual Studio Code](https://marketplace.visualstudio.com/items?itemName=DEVSENSE.phptools-vscode).
2. Add [debug configuration](https://code.visualstudio.com/docs/debugtest/debugging-configuration#_launch-configurations)
   into your `.vscode\launch.json` file.

   Example:

   ```json
   {
     "version": "0.2.0",
     "configurations": [
       {
         "name": "Listen for Xdebug",
         "type": "php",
         "request": "launch",
         "port": 9008,
         "pathMappings": {
           "/app": "${workspaceFolder}"
         }
       }
     ]
   }
   ```

3. Use [Run and Debug](https://code.visualstudio.com/docs/debugtest/debugging#_start-a-debugging-session)
   options and run `Listen for Xdebug` command to listen for upcoming connections
   with [the **Xdebug extension**](https://xdebug.org/docs/step_debug#browser-extensions)
   installed and active.

## Troubleshooting

Inspect the installation with the following command.
The Xdebug version should be displayed.

```console
$ docker compose exec php php --version

PHP ...
    with Xdebug v3.x.x ...
```
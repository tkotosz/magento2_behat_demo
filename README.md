# magento2_behat_demo

Please follow the below steps to get started, if you encounter any issues installing the dependencies or provisioning the development environment, please check the [Common Issues](#common-issues) section first.

## Development Environment

### Getting Started

#### Prerequisites

##### General

- Access to LastPass folders
  - `Shared-magento2_behat_demo-Servers` and `Shared-magento2_behat_demo-Accounts`

##### Docker

- A working Docker setup
  - On MacOS, use [Docker for Mac](https://docs.docker.com/docker-for-mac/install/).
  - On Linux, add the official Docker repository and install the "docker-ce" package.
    You will also need to have a recent [docker-compose](https://docs.docker.com/compose/install/) version - at least `1.24.0`.

#### Setup

1. Install [workspace](https://github.com/my127/workspace)
2. Copy the LastPass entry "magento2_behat_demo: Development Environment Key" to a new blank file named `workspace.override.yml` in the project root.
3. Run `ws install`

Once installed, the site should be available at [https://magento2_behat_demo.my127.site](https://magento2_behat_demo.my127.site).

### Development environment cleanup

To stop the development environment, run `ws disable`.

To start the development environment again, run `ws enable`.

To remove the development environment, run `ws destroy`.

### Frontend

The frontend build should be automatically done as part of bringing up the environment.

To trigger a rebuild, run `ws frontend build`.

To watch for changes, run `ws frontend watch`.

To gain access to the `console` container where the builds happen: `ws frontend console`.

### MySQL Access

MySQL can be used either via command line tools via `ws db console` or via GUI tools.

In your GUI tool, set up a new connection to localhost with the port being the returned port number from:
```bash
ws port mysql
```

This port will change each time the project environment is started, as docker will allocate a random unused port
on your host machine.

To set a consistent port for this project, choose a port number that you think will be unique across all projects
that your developers will encounter (e.g. not 3306!). Acceptable range of ports is 1-65535.

Once you have a port number, you can define it in the workspace.yml with:
```yaml
attribute('database.port_forward'): portNumberHere
```
The connection username and password is listed under the `mysql` service environment section in `docker-compose.yml` in
the project root.

### Xdebug

Xdebug is turned off by default as it drastically slows down requests for all developers.

To enable, run `ws feature xdebug on`. To turn off again, `ws feature xdebug off`.

To enable on CLI in `ws console`, run `ws feature xdebug cli on`. To turn off again, `ws feature xdebug cli off`.

Xdebug is set up to listen to your computer's 9000 port once enabled, so all you would need to do in your IDE is:
1. Create a mapping from the project root to `/app` for name `workspace`, hostname `localhost` and port 80.
2. Listen for connections.

[Here's a good guide for PhpStorm](https://www.jetbrains.com/help/phpstorm/zero-configuration-debugging.html).

If you have trouble with triggered requests not starting connections to your IDE, check that
`sudo lsof -i :9000 | grep LISTEN` on your host shows process from your IDE.
If it doesn't, stop the indicated process (e.g. `php-fpm`) and toggle the Xdebug listen button off and on again in PhpStorm.

### Performance on MacOS

Page load times with Docker for Mac can vary considerably. This is especially so when there is a large
quantity of small files, such as with a large composer vendor folder.

[docker-sync](https://github.com/EugenMayer/docker-sync/) is enabled on this workspace environment to
try to overcome this.
It enables production-like performance at the cost of having to synchronise files with an intermediate
"data" container.

If you don't like the tradeoff of having to synchronise files, you can turn docker-sync off
with `ws feature docker-sync off`.

If your page loads too slowly, you can turn docker-sync back on again  with `ws feature docker-sync on`

#### Mutagen file sync

[Mutagen](https://mutagen.io/documentation/transports/docker) is another tool to synchronize files between host machine
and docker containers, just like docker-sync. We have integrated mutagen for synchronizing files as an option of docker-sync.
This tool is still in beta phase, but you can try it yourself if you are not happy with docker-sync.
Following are some useful commands regarding Mutagen.

```bash
# To switch to Mutagen file sync
ws switch mutagen
# To switch back to docker-sync
ws switch docker-sync
# To check the Mutagen sync status (sync is ready when status is "Watching for changes")
mutagen monitor
# To debug an errored sync
mutagen list
```

### Common Issues

As setup issues are encountered please detail with step by step fix instructions, and where possible update the project or the upstream workspace harness itself to provide a more permanent fix.

* If you use docker-sync and notice that your changes aren't synchronising to the environment:
  * Check if your file exists with your changes in `ws console`
  * If your file in `ws console` has changed okay, check your project for any caching that
    would prevent changes to source code appearing immediately.
  * If the file changes do not appear in `ws console` reasonably quickly, it might be that
    Docker for Mac is overwhelmed with file change events.
  * Restarting Docker for Mac using the system tray icon's menu and then running `ws enable` again
    will fix it.

# License

Copyright 2019, Inviqa

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

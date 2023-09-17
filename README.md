# cybersecurity-app

## Installation

1. Clone this rep

2. Go inside folder `/docker`
```bash
cd ./docker
```

3. Run docker composer
```bash
docker-compose up --build
```

4. Enter `app` container
```bash
docker exec -it app /bin/bash
```

5. Install dependencies
```
composer install
```

## Docker containers
web
```shell
docker exec -it web /bin/sh
```
app
```shell
docker exec -it app /bin/bash
```
db
```shell
docker exec -it db /bin/bash
```

## Docker cleaning
Remove unused images

```bash
 docker image prune
 ```

Remove unused volumes

```shell
docker volume prune
```
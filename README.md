
<h3 align="center">GESTION D'ÉVÉNEMENTS SPORTIFS</h3>
<!-- TABLE OF CONTENTS -->

### Built With
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)

## Getting Started
### Prerequisites

* composer : https://getcomposer.org/download/

* php >= 8.2.* : https://www.php.net/downloads

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/antoinebtn/ESGI_SiteSportEvent
   ```
2. Install dependencies
   ```sh
   composer install
   ```

3. (DOCKER) Start Docker DB/PhpMyAdmin
   ```sh
   docker compose up -d
   ```

4. (if you don't use docker) Configure the database in `.env`
   ```env
   DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8"
   ```

5. Create the database, migrate the migrations and load the fixtures
   ```sh
   symfony console doctrine:database:create
   symfony console doctrine:migrations:migrate
   symfony console doctrine:fixtures:load
   ```
   
6. The application is accessible on https://127.0.0.1:8000/

### Features 

1. You can see different events and register with a username and email
2. You cannot register to past event (event 1 for example)
3. You can see your distance to the event by clicking on "Calculer" on the show event page
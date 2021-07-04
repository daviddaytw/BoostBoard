# BoostBoard

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/41dfe17ea6fa4388835b0750b4ec3771)](https://www.codacy.com/gh/dj6082013/BoostBoard/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=dj6082013/BoostBoard&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://app.codacy.com/project/badge/Coverage/41dfe17ea6fa4388835b0750b4ec3771)](https://www.codacy.com/gh/dj6082013/BoostBoard/dashboard?utm_source=github.com&utm_medium=referral&utm_content=dj6082013/BoostBoard&utm_campaign=Badge_Coverage)
[![GitHub release](https://img.shields.io/github/release/dj6082013/BoostBoard.svg)](https://GitHub.com/dj6082013/BoostBoard/releases/)
[![GitHub license](https://img.shields.io/github/license/dj6082013/BoostBoard.svg)](https://github.com/dj6082013/BoostBoard/blob/master/LICENSE)
[![Github all releases](https://img.shields.io/github/downloads/dj6082013/BoostBoard/total.svg)](https://github.com/dj6082013/BoostBoard/releases/)

## About BoostBoard

BoostBoard is a web dashboard framework for monitor and management.
Our goal is to create a elegant, highly adaptable and Pain-less framework for a panel or dashboard.
For this purpose in mind, BoostBoard include the following feature:

- Independent configuration for each module.

## Usage

### Requirement

You have two choice to use BoostBoard, with docker or without docker:

#### With Docker

You'll need Docker and docker-compose installed, the following command will create a development server on port 8080.
```bash
docker-compose up

# To run in the background
docker-compose up -d
```

For the first time to run the BoostBoard, you'll have to download the dependencies first, execute the following command to install dependencies.
```bash
docker-compose exec app composer install
```
Visit the `http://localhost:8080` you should see the login page of BoostBoard.

#### Without Docker (Manually Install)

Without docker you will need to manually install PHP 8, Apache HTTP Server and SQLite driver, after that put the entire directory in the apache server directory usually `/var/www/`.

Before running, you will need to download the dependences first, execute the following command to install dependencies.
```bash
composer install
```
Visit the `http://localhost` you should see the login page of BoostBoard.

### Getting Start

This repository is a template repository, which means that you can copy this repository and modify the contain for your own usage.

### Directory structure

In this README file we will only cover the directory at root level, it learn more in the sub-directory, please read the README file inside that particular directory.

- `data`: The data used by BoostBoard, for example: database that contain the user information.
- `src`: The source code directory, if you want to add a module or a page in the BoostBoard, please read the README inside.
- `theme`: The most fundenmental template of BoostBoard, you can customize it as you want.

## Contributing

Thank you for considering contributing to the BoostBoard framework! Please read the [CONTRIBUTING](https://github.com/dj6082013/BoostBoard/blob/master/CONTRIBUTING.md) for more details.

## Code of conduct

In order to ensure that the BoostBoard community is welcoming to all, please review and abide by the [Code of Conduct](https://github.com/dj6082013/BoostBoard/blob/master/CODE_OF_CONDUCT.md).

## License

The BoostBoard framework is licensed under the [MIT License](https://opensource.org/licenses/MIT).

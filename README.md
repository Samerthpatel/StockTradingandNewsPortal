# Server Documentation

This repository contains documentation for the setup and configuration of different servers involved in the project.

## IP Address for Each Server (will be needed during setup)

- Web Server:
  - Production: 192.168.192.97
  - Development: 192.168.192.178
  - QA: 192.168.192.252

- Database Server:
  - Production: 192.168.192.22
  - Development: 192.168.192.186
  - QA: 192.168.192.95

- DMZ Server:
  - Production: 192.168.192.26
  - Development: 192.168.192.39
  - QA: 192.168.192.90

- Deployment Server: 192.168.192.186

## Initial Steps when Creating a New Server

Follow the steps below for the initial setup of any server:

1. `sudo apt-get upgrade`
2. `sudo apt-get install git`
3. `git clone https://github.com/Samerthpatel/it490project`
4. `sudo apt-get install php`
5. `sudo apt-get install php-amqp`
6. `sudo apt-get install rabbitmq-server`
7. `sudo rabbitmq-plugins enable rabbitmq_management`
8. `sudo apt-get install ssh`
9. `sudo apt-get install curl`
10. `curl -s 'https://raw.githubusercontent.com/zerotier/ZeroTierOne/master/doc/contact%40zerotier.com.gpg' | gpg --import && \ if z=$(curl -s 'https://install.zerotier.com/' | gpg); then echo "$z" | sudo bash; fi`
11. `sudo zerotier-cli join 3efa5cb78a4776fe`

## Web Server Setup Instructions

Follow the steps below to set up the web server for Development, QA, and Production:

1. Authenticate on ZeroTier and assign the correct IP address for the server.
2. Drag the website folder from the GitHub repository and put it on the desktop.
3. In the `website/rabbitmq/` folder, change the `testRabbitMQ.ini` file and put in the correct IP addresses depending on the server. Refer to the table or diagram for the IP addresses.
4. Copy the folder to `/var/www/html`.
5. To access the web pages, edit `/etc/hosts` and add the IP address of the web server and the domain name.
6. Restart Apache by running `sudo service apache2 restart`.
7. The website can now be accessed by going to the domain, e.g., www.cryptocoders.org.

## Database Server Setup Instructions

Follow the steps below to set up the database server for Development, QA, and Production:

1. Authenticate on ZeroTier and assign the correct IP address for the server.
2. Install MySQL with `sudo apt-get install mysql-server`.
3. Assign a root password:
   a. `sudo mysql -u root`
   b. `ALTER USER 'root'@'localhost' IDENTIFIED BY 'the-new-password';`
4. Drag the Database folder from the Git repository and put it on the desktop.
5. Make sure that the SQL user and password match in the `database/server_config.php` file.
6. Log into RabbitMQ and make a virtual host called TestHost:
   a. Make a testExchange and testQueue and bind them for the database.
   b. Make a dmzExchange and dmzQueue and bind them for the DMZ.
7. In the `database/rabbitmq/` folder, change the `testRabbitMQ.ini` file and put in the correct IP addresses depending on the server. Refer to the table or diagram.
   a. In this case, it will be the IP of the machine since RabbitMQ runs on the database server.
8. Use the `it490.sql` file in the folder to make the tables needed for the website.
9. The database server can be started by `cd` into the folder and running `./databaseserver.php`.

## DMZ Server Setup Instructions

Follow the steps below to set up the DMZ server for Development, QA, and Production:

1. Authenticate on ZeroTier and assign the correct IP address for the server.
2. Drag the `dmz` folder from the GitHub repository and put it on the desktop.
3. In the `dmz/rabbitmq/` folder, change the `testRabbitMQ.ini` file and put in the correct IP addresses depending on the server. Refer to the table or diagram.
4. In the `/dmz/dmzserver.php` file, add in the right API keys. APIs used are listed in the API section.
5. The DMZ server can be started by `cd` into the folder and running `./dmzserver.php`.

## Deployment Server Setup Instructions

Follow the steps below to set up the deployment server:

1. Drag the `deployment` folder from GitHub and put it on the desktop.
2. In the `rabbitmq/testrabbitMQ.ini` file, put in the IP address of the deployment server.
3. Use the steps outlined in the database section to install SQL and configure the root password.
4. Use the `/deployment/deployment.sql` to make the tables required for the server.
5. SSH into all the machines to test if they can connect.
6. The `deployment.sh` script can be run to deploy new versions to QA and Production:
   a. Use `bash deployment.sh` to run the script.
   b. Follow the prompt to deploy or rollback changes.

## Systemd Configuration

A systemd service can be made to automatically run the DMZ and database server files. Follow the steps below to set it up:

1. Make a `script.sh` file that can run the database/DMZ server file.
2. Give the script executable permission by doing `sudo chmod +x 'path to script file'`.
3. `cd /etc/systemd/system/`
4. `sudo vi 'servicename'.service`
5. Enter the code found below in the file. Change the file paths accordingly.

```plaintext
[Unit]
Description=My custom service

[Service]
Type=simple
TimeoutSec=0
User=root

ExecStart=/path/to/your/script.sh
Restart=always

[Install]
WantedBy=multi-user.target
```

6. `sudo systemctl enable 'servicename'.service` to enable the service.
7. `sudo systemctl start 'servicename'.service` to start the service.
8. Check the status by doing `sudo systemctl status 'servicename'.service`.

## APIs

1. [https://newsapi.org/](https://newsapi.org/)
   - To get the most recent financial market news.
   - Key=767022eecc34405bbc4f2c84556fdcf5

2. [https://www.alphavantage.co/](https://www.alphavantage.co/)
   - To get the historical stock data.
   - Key=5H2X5E07Q3FPXXP9

3. [https://www.stockdata.org/pricing](https://www.stockdata.org/pricing)
   - To get the most recent stock price and relevant stock news for trading.
   - Key=tN7dV7K9FFMKGh49Bf

## Github repository
- https://github.com/Samerthpatel/it490project
- Relevant Branches:
  - Master (Main Branch)
  - push
  - chatroom
  - rabbitmq
  - website
  - stockdata
  - stocktrade

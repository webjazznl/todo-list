# Todo-App
Auteur: Henk Siebelink 
# Installatie
Docker Desktop installeren en de Ubuntu app van windows op WSL-2

In je Ubuntu op WSL-2 machine:

1. Update je pakketbron
sudo apt update && sudo apt upgrade -y

2. Installeer vereisten zoals curl, PHP en andere benodigde extensies
```
sudo apt install curl php-cli php-mbstring unzip git php-xml php-dom php-curl -y
```

3. Download de Composer-installer indien composer --version niet werkt in Ubuntu
```
curl -sS https://getcomposer.org/installer | php
```
4. Verplaats de Composer-binaire naar een globale locatie
```
sudo mv composer.phar /usr/local/bin/composer
```
5. Controleer of Composer correct is geïnstalleerd
```
composer --version
```
6. Clone deze repo
```
git clone https://github.com/webjazznl/todo-list.git
```

7. Installeer afhankelijkheden
```
cd todo-list
composer install
```

8. Kopieer .env.example naar .env
```
cp .env.example .env 
```
9. Start docker containers
```
./vendor/bin/sail up -d
```
TIP: Als mysql of een andere container niet start, de storage van containers verwijderen en containers herstarten: 
```
docker-compose down --volumes
```
Conditie: alle containers zijn gemaakt en draaien 

10. Draai de databasemigraties ./vendor/bin/sail artisan migrate en open daarna http://localhost/

```
./vendor/bin/sail artisan migrate

```
11. Test het commando om mails te versturen voor verlopen taken 
```
./vendor/bin/sail artisan app:send-overdue-task-emails
```
Ga naar http://localhost:8025/ om de mails te bekijken.

Stel een andere ontvanger in in de .env file: MAIL_RECIPIENT

# Testen
```
./vendor/bin/sail artisan test
```
Zie .env.testing als lokaal testen niet werkt

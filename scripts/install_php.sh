#! /bin/sh
sudo apt install lsb-release
curl https://packages.sury.org/php/apt.gpg | sudo tee /usr/share/keyrings/suryphp-archive-keyring.gpg >/dev/null
echo "deb [signed-by=/usr/share/keyrings/suryphp-archive-keyring.gpg] https://packages.sury.org/php/ $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/sury-php.list

sudo apt update
sudo apt install php8.4-{cli,pdo,mysql,zip,gd,mbstring,curl,xml,bcmath,common,bz2,fpm,imap,xdebug,mcrypt,odbc,imagick,xsl,yaml,oauth,pspell,readline}
sudo apt install php-pear

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir="/usr/local/bin" --filename="composer"
php -r "unlink('composer-setup.php');"

sudo pear channel-update pear.php.net
sudo pear install Console_CommandLine

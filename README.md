# Pete's Gallery

A very simple directory based code igniter photo gallery

## Install instructions for debian based distros
### Install packages
*apache root is /var/www*

    apt install apache2
    apt install php7.3 -y
    apt install php-json php-xml curl php-intl php-mbstring zip unzip php-zip -y
    apt install imagemagick ffmpeg vim exiftool dcraw -y
    a2enmod rewrite
### Install composer
Get composer from https://getcomposer.org/download/

    wget -O composer https://getcomposer.org/installer
    chmod +x composer
    cd /var/www/html
    ~/composer create-project codeigniter4/appstarter gallery
### Set document root

    vim /etc/apache2/sites-available/000-default.conf
    DocumentRoot /var/www/html/gallery/public
enable .htaccess

    vim /etc/apache2/apache2.conf
in '<Directory /var/www/>' change:

    AllowOverride None
to:

    AllowOverride All
then enable mod_rewrite

    a2enmod rewrite
restart apache2 to load new config

    systemctl restart apache2
enable writable writable
    
    cd /var/www/html/gallery
    find writable/ -type d -print | xargs chmod 777
    find writable/ -type f -print | xargs chmod 666
set development mode

    cp env .env
    vim .env
    CI_ENVIRONMENT = development
    app.baseURL = 'http://<IP>/'
set gallery to be the default page

    vim /var/www/html/gallery/app/Config/Routes.php
change

    $routes->setDefaultController('Home');
to

    $routes->setDefaultController('Gallery');
and

    $routes->get('/', 'Home::index');
to
    $routes->get('/', 'Gallery::index');

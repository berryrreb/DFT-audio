# DFT-audio

Aplicación que descompone y filtra audio gracias a la transformada discreta de fourier.

## Prerrequisitos

+ Docker 1.13 o superior
+ SO base Linux

Levantar el ambiente:

Se utilizará php-fpm como servidor php y nginx como servidor web. Todo en contenedores de docker.

```sh
docker run -d --restart=always --name php-fpm \
    -v /var/containers/nginx/etc/nginx/vhosts/php:/var/www/html:z \
    -v /var/containers/php-fpm/opt/uploads/:/opt/uploads/:z \
    php:7-fpm

docker run -td --restart=always --name=nginx --privileged=false -p 80:80 -p 443:443 \
    --link php-fpm:php-fpm \
    --volume=/var/containers/shared/var/www/sites:/var/www/sites:z \
    --volume=/var/containers/nginx/var/log/nginx:/var/log/nginx:z \
    --volume=/var/containers/nginx/etc/nginx/vhosts:/etc/nginx/vhosts:z \
    --volume=/var/containers/nginx/etc/nginx/keys:/etc/nginx/keys:z \
    --volume=/var/containers/nginx/etc/nginx/conf.d:/etc/nginx/conf.d:z \
    --volume=/var/containers/nginx/var/cache/nginx:/var/cache/nginx:z  \
    --volume=/var/containers/nginx/var/backups:/var/backups:z \
    --volume=/etc/localtime:/etc/localtime:ro \
    --hostname=nginx.service \
    docker.io/berryrreb/nginx-rhel7
```

Apuntar el nombre de dominio a localhost(si necesario):

```sh
sudo echo '127.0.0.1 dft.local.com' >> /etc/hosts
```

Exponer aplicación con nginx mediante el vhost: */var/containers/nginx/etc/nginx/vhosts/dft.conf*

```sh
server {
    listen 80;
    index index.php index.html;
    server_name dft.local.com;
    root /etc/nginx/vhosts/php;
    client_max_body_size 20M;

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php-fpm:9000;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME /var/www/html$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
}
```

<!-- Instalar lame mp3 encoder

```sh
#Nginx
docker exec -it nginx microdnf clean all
docker exec -it nginx microdnf install -y yum
docker exec -it nginx yum install -y https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
docker exec -it nginx yum install -y lame

#Php-fpm
docker exec -it php-fpm apt-get update -y
docker exec -it php-fpm apt-get install lame php-common ucf php7.4-common libgd3 -y
``` -->

Recargar nginx

```sh
docker exec -it nginx nginx -s reload
```

<!-- Dar permisos correspondientes al direcotorio donde se almacenarán los archivos.

```sh
chmod -R 777 /var/containers/php-fpm/opt/uploads/
``` -->

Clonar repositorio y mover archivos fuente a directorio dedicado a php.

```sh
git clone https://github.com/berryrreb/DFT-audio.git ~/DFT-audio
sudo cp ~/DFT-audio/source/* /var/containers/nginx/etc/nginx/vhosts/php
```

Ir a localhost o a dft.local.conf en el navegador para comprobar que funciona php.

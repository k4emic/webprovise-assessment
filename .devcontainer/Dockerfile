FROM mcr.microsoft.com/devcontainers/php:1-8.2-bookworm

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

RUN mv /usr/local/etc/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/00-xdebug.ini
COPY ./xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

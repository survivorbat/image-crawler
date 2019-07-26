FROM nginx:1.17.2-alpine

COPY --chown=root:root docker/nginx/ /
COPY src/public/ /var/www/html/

ENTRYPOINT /bin/docker-entrypoint

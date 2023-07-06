FROM nginx:stable-alpine

RUN mkdir -p /var/ww/html

ADD ../nginx/default.conf /etc/nginx/conf.d/default.conf

COPY ../. /var/www/html

RUN apk update && \
      apk add sudo && \
      apk add bash
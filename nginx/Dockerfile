FROM nginx:1.27.5-alpine-slim

RUN apk add --no-cache bash apache2-utils
COPY htpasswd/htpasswd.sh ./htpasswd.sh
RUN sed -i 's/\r$//' ./htpasswd.sh
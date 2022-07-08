FROM nginx:latest

ARG BUILD_ARGUMENT_ENV=dev
ENV ENV=$BUILD_ARGUMENT_ENV

RUN apt-get update -y && \
    apt-get upgrade -y && \
#    apt-get install -y bash \
#    		certbot \
#    		python3-certbot-nginx

RUN  set -e ;apt-get install -y openssl;

#RUN certbot certonly --standalone -d whoami.mydomain.com

RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log && \
    rm -rf /etc/nginx/conf.d/*

# create folder for certificates
RUN mkdir -p /etc/nginx/certificates

# generate certificates
# TODO: change it and make additional logic for production environment
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/certificates/key.pem -out /etc/nginx/certificates/cert.pem -subj "/C=AT/ST=Vienna/L=Vienna/O=Security/OU=Development/CN=example.com"

# put nginx config
COPY ./docker/$BUILD_ARGUMENT_ENV/nginx.conf /etc/nginx/conf.d/default.conf

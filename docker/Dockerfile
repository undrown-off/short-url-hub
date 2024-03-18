FROM debian:bullseye-slim
LABEL Author="Artur Skomarohov"
WORKDIR /app
RUN apt-get update && apt-get upgrade -y
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
CMD echo "It's my first docker container__ Author: Artur Skomarohov"
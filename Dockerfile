FROM php:7.3-cli

ENV COMPOSER_SCRIPT composer_installer.sh
ENV NODE_VERSION 14.9.0
ENV PATH="$PATH:/usr/lib/node/bin"

COPY ./_/docker/$COMPOSER_SCRIPT /root/

RUN apt-get update
RUN apt-get install -qq zip curl wget
RUN bash /root/$COMPOSER_SCRIPT
RUN wget -O /tmp/node-$NODE_VERSION-linux-x64.tar.xz https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.xz
RUN tar -xf /tmp/node-$NODE_VERSION-linux-x64.tar.xz
RUN mv node-* /usr/lib/node
RUN rm /tmp/node-$NODE_VERSION-linux-x64.tar.xz
RUN npm -g config set user root
RUN useradd -d /home/tester -m -s /bin/bash tester
RUN adduser tester sudo

WORKDIR /home/tester
RUN chown -R tester:tester /home/tester
USER tester

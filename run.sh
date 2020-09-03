#!/bin/bash

set -e

current_directory=$(pwd)
basename=$(basename ${current_directory})

printf -- "building %s image\n" ${basename}
docker image build -t ${basename} .

printf -- "running %s container\n" ${basename}
docker container run --rm -it \
    -v ${current_directory}:/var/www/html \
    ${basename} bash


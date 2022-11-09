# Install composer dependencies with a compatible PHP environment hosted in a
# container.

# See Laravel docs:
# Installing Composer Dependencies For Existing Projects
# https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs;

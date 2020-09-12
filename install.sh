echo "Initiallizing development environment...";


rm -rf .git/


if [[ ! -d ./code/html ]]
  then
    mkdir ./code;
    mkdir ./code/html;
fi;

cd ./code/html;

echo "Geting the latest code...";

git init;

git remote add origin git@gitlab.com:epione-tests/scshasha-be.git;

git pull origin master;
#
composer install;

cd ../../;

echo "Creating Laravel .env file";
cp ./code/html/.env.example ./code/html/.env;

echo "Booting up Docker containers...";

docker-compose up --build -d;


# echo "Running composer install";
# docker exec -it scshasha-be-php composer install;


echo "Running DB migrations";
docker exec -it scshasha-be-php php artisan migrate;
#
# echo "Running sample seed";
# docker exec -it scshasha-be-php php artisan db:seed --class=BookSeeder;

echo "listing routes";
docker exec -it scshasha-be-php php artisan route:list;

echo "sh into php container";
docker-compose exec php sh;

echo "Initiallizing development environment...";
if [[ -d ./.git/ ]]
  rm -rf .git/
fi;


if [[ ! -d ./code/html ]]
  then
    mkdir ./code;
    mkdir ./code/html;
fi;

cp ./.env.sample ./.env

cd ./code/html;

echo "Geting the latest code...";

git init;

git remote add origin https://github.com/scshasha/support-tickets-app.git;

git fetch origin;

git pull origin master;


echo "Installing dependencies";
composer install;
npm install;

cd ../../;

echo ".env configuration";
cp ./code/html/.env.example ./code/html/.env;

echo "Booting up Docker containers...";
docker-compose up --build -d;



echo "Running DB migrations";
docker exec -it php artisan migrate;



echo "Running DB seeds";
docker exec -it php artisan db:seed;



echo "listing routes";
docker exec -it php artisan route:list;



echo "Clear config..."
docker exec -it php artisan config:clear;



echo "Clear cache..."
docker exec -it php artisan cache:clear;



echo "sh into php container";
docker-compose exec php sh;


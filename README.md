```
docker exec -it ten_container bash
nvm install v16
nvm use v16
cd themes/backend
npm install 
npm run dev

php artisan theme:publish backend
```
 
## create admin user username: admin, password : 1
 
```
 php artisan admin:create-root-user admin 1
```
 

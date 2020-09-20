docker build -t franslourens/nginx-laravel:latest -t franslourens/nginx-laravel:$SHA -f ./nginx/Dockerfile ./nginx
docker build -t franslourens/php-laravel:latest -t franslourens/php-laravel:$SHA -f ./php/Dockerfile ./php

docker push franslourens/nginx-laravel:latest
docker push franslourens/php-laravel:latest

docker push franslourens/nginx-laravel:$SHA
docker push franslourens/php-laravel:$SHA

kubectl apply -f k8s
kubectl set image deployments/client-deployment client=franslourens/php-laravel:$SHA

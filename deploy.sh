docker build -t franslourens/nginx-laravel:latest -t franslourens/nginx-laravel:$SHA -f ./nginx/Dockerfile ./nginx
docker build -t franslourens/php-laravel:latest -t franslourens/php-laravel:$SHA -f Dockerfile .

docker push franslourens/nginx-laravel:latest
docker push franslourens/php-laravel:latest

docker push franslourens/nginx-laravel:$SHA
docker push franslourens/php-laravel:$SHA

kubectl apply -f k8s/database-persistent-volume-claim.yaml
kubectl apply -f k8s/database-persistent-volume-claim.yaml
kubectl apply -f k8s/mysql-cluster-ip-service.yaml
kubectl apply -f k8s/mysql-deployment.yaml
kubectl apply -f k8s/ingress-service.yaml
kubectl apply -f k8s/client-cluster-ip-service.yaml
kubectl apply -f k8s/client-deployment.yaml

kubectl set image deployments/client-deployment fpm=franslourens/php-laravel:$SHA

#!/bin/sh -ex

# For details about this script, see https://docs.shopsys.com/en/latest/kubernetes/continuous-integration-using-kubernetes/

# This restarts the application in Kubernetes, assuming it has been already built
# Useful after deleting the namespace (via "kubectl delete namespace ${JOB_NAME}")

# Create namespace if not exists and deploy
kubectl create namespace ${JOB_NAME} || true

# Go to kustomize folder
cd project-base/kubernetes/kustomize

# Echo Kustomize build for debugging
kustomize build overlays/ci

# Apply kubernetes manifests by output of Kustomize Build
kustomize build overlays/ci | kubectl apply -f - --namespace=${JOB_NAME}

# Wait for containers to rollout
kubectl rollout status --namespace=${JOB_NAME} deployment/adminer --watch
kubectl rollout status --namespace=${JOB_NAME} deployment/elasticsearch --watch
kubectl rollout status --namespace=${JOB_NAME} deployment/postgres --watch
kubectl rollout status --namespace=${JOB_NAME} deployment/redis --watch
kubectl rollout status --namespace=${JOB_NAME} deployment/redis-admin --watch
kubectl rollout status --namespace=${JOB_NAME} deployment/selenium-server --watch
kubectl rollout status --namespace=${JOB_NAME} deployment/smtp-server --watch
kubectl rollout status --namespace=${JOB_NAME} deployment/webserver-php-fpm --watch

# Find the running webserver-php-fpm pod
PHP_FPM_POD=$(kubectl get pods -n ${JOB_NAME} -l app=webserver-php-fpm -o=jsonpath='{.items[0].metadata.name}')

# Run phing build in the pod
kubectl exec --namespace=${JOB_NAME} ${PHP_FPM_POD} -- ./phing -D production.confirm.action=y clean dirs-create elasticsearch-index-recreate elasticsearch-export error-pages-generate

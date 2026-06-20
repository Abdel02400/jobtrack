Write-Host "Starting JobTrack setup..." -ForegroundColor Cyan

docker compose up -d --build

docker compose exec backend composer install

docker compose exec backend php bin/console lexik:jwt:generate-keypair --skip-if-exists

docker compose exec backend php bin/console doctrine:migrations:migrate --no-interaction

Write-Host ""
Write-Host "JobTrack is ready." -ForegroundColor Green
Write-Host "Backend:  http://localhost:8000"
Write-Host "Swagger:  http://localhost:8000/api/docs"
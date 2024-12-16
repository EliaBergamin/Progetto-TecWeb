Write-Host "Arresto e rimozione dei volumi..." -ForegroundColor Yellow
docker compose down --volumes
Write-Host "Docker Compose fermato." -ForegroundColor Green

docker compose up -d
Write-Host "Docker Compose avviato." -ForegroundColor Green



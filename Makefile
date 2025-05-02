# Makefile
.PHONY: setup install migrate seed serve test docker-up docker-down fix-permissions

setup: docker-up install fix-permissions migrate seed
	@echo "Project setup complete. API is available at http://localhost:8080/api/products"

install:
	@docker-compose exec app composer install
	@cp .env.example .env
	@docker-compose exec app php artisan key:generate

fix-permissions:
	@docker-compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
	@docker-compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
	@docker-compose exec app php artisan view:clear

migrate:
	@docker-compose exec app php artisan migrate

seed:
	@docker-compose exec app php artisan db:seed

serve:
	@docker-compose exec app php artisan serve

docker-up:
	@docker-compose up -d --build
	@echo "Waiting for services to be healthy..."
	@sleep 10 # Give services time to start
	@docker-compose ps
	@echo "Services are up. Access API at http://localhost:8080/api/products"

docker-down:
	@docker-compose down -v

test:
	@docker-compose exec app php artisan test
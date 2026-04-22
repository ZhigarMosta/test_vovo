.env: .env.example

install:
	cp .env.example .env
	docker compose build
	docker compose up -d

up:
	docker compose up -d

down:
	docker compose down

shell:
	docker compose exec app sh

build:
	docker compose exec app npm run build
# Быстрый старт

## Запуск в development
1. Первый раз:
```bash
make dev-init
```

2. Открываем проект
```text
http://localhost:8080
```

## Полезные команды
Применить миграции:
```bash
make dev-migrate
```

Поднять проект:
```bash
make dev-up
```

Остановить проект:
```bash
make dev-down
```

Запустить тесты:
```bash
make test
```

Зайти внутрь приложения:
```bash
make dev-shell
```

Посмотреть логи приложения:
```bash
make logs-app
```

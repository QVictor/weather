# Weather statistic
A weather application made using Laravel, Vue and Open Weather Map API

## Installation
1. Clone repository
```bash
git clone git@github.com:QVictor/weather.git
```

2. Install the required packages
```bash
composer install
```

3. Copy .env
```bash
cp .env.example .env
```

4. Run sail
```bash
./vendor/bin/sail up
```

5. Generate key
```bash
sail php artisan key:generate
```

6. Install npm packages
```bash
npm install
```

7. Run num dev
```bash
sail npm run dev
```

8. Run migrate
```bash
sail php artisan migrate
```

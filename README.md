# Turnip Queue

## About Turnip Queue

Turnip Queue is designed to make a queue for people wishing to visit your island in Animal Crossing: New Horizons. It shows the Dodo Code to visit your island to a set number of people at a time, with live updates to the provided via pusher channels. See it in action at [https://turnip-queue.schlachter.xyz](https://turnip-queue.schlachter.xyz)

## Installation

### Prerequisites

There are a few prerequisites by way of software and api keys in order to install this package. They include:

- PHP 7.2.5 or higher
- MySQL or another Laravel-compatible database
- Composer
- NPM
- Pusher Channel API keys, which can be obtained for free for development from [https://pusher.com/channels](https://pusher.com/channels)
- Google ReCaptcha v3 API keys, which can be obtained for free from [https://www.google.com/recaptcha/about/](https://www.google.com/recaptcha/about/)
- An email provider (I use GMail with SMTP and an App Password)

### Installation Process

1)  Clone the repository from GitHub
    ```sh
    https://github.com/mschlachter/turnip-queue.git && cd turnip-queue
    ```
    or
    ```sh
    git@github.com:mschlachter/turnip-queue.git && cd turnip-queue
    ```

2)  Install the Composer dependencies
    ```sh
    composer install --no-dev
    ```
    or, for development
    ```sh
    composer install
    ```

3)  Copy the example .env file and fill in the needed values and API keys
    ```sh
    cp .env.example .env && nano .env
    ```

4)  Generate an encryption key for Laravel
    ```sh
    php artisan key:generate
    ```

5)  Run the migrations
    ```sh
    php artisan migrate
    ```

6)  Install the node packages and run the npm script
    ```sh
    npm install && npm run prod
    ```
    or, for development
    ```sh
    npm install && npm run watch
    ```

Navigate to the site with your browser and you should be good to go. If you're using Valet, it'll likely be located at [http://turnip-queue.test](http://turnip-queue.test)

### Cronjobs and Supervisor tasks

For proper function there are also two cronjobs and one Supervisor task that need to be run.

The cronjobs are:
```sh
* * * * * php {$PROJECT_DIRECTORY}/artisan queue:purge-seekers
*/5 * * * * php {$PROJECT_DIRECTORY}/artisan queue:purge-queues

```

The Supervisor task (should be run continuously) is:
```sh
php {$PROJECT_DIRECTORY}/artisan queue:work --daemon
```

## Contributing

Thank you for considering contributing to the Turnip Queue! The contribution guide can be found in the [CONTRIBUTING.md](CONTRIBUTING.md) file of this package.

## Security Vulnerabilities

If you discover a security vulnerability within this application, please send an e-mail to Matthew Schlachter via [matthew@schlachter.xyz](mailto:matthew@schlachter.xyz). All security vulnerabilities will be promptly addressed.

## License

This package is Open-Source software licensed under the [Attribution 4.0 International (CC BY 4.0) License](https://creativecommons.org/licenses/by/4.0/).

## Acknowledgements

Sound effect for the notification was obtained from <a href="https://www.zapsplat.com">https://www.zapsplat.com</a>
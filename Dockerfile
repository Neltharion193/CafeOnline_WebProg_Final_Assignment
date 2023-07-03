FROM bitnami/laravel:10.0.4
COPY ./ /app/

RUN composer install
RUN php artisan key:generate

EXPOSE 8000
CMD ["php", "artisan","serve", "--port=8000", "--host=0.0.0.0"]

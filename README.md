# Depression
An expert system aimed to help diagnose depression and similar disorders, which I wrote for my thesis.

![image](https://user-images.githubusercontent.com/47256917/224542655-98557d26-a7b5-48a1-a34d-42ea4eac55d9.png)
# Installation
Create a database and edit the ```.env``` file to match your environment configuration, then run ```composer update && php artisan migrate:fresh --seed```.
# Usage
Run ```php artisan serve``` and visit http://localhost:8000 (or whichever port ```artisan``` serves on) on your browser.

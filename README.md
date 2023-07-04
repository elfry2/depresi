# Depression
An expert system aimed to help diagnose depression and similar disorders, which I wrote for my thesis. Supports score-based classification and naive bayes.

![image](https://user-images.githubusercontent.com/47256917/224542705-9163a030-b322-4709-86da-3b108c12fa16.png)
## Installation
Create a database, copy the ```.env.example``` file and rename it to ```.env```, edit the ```.env``` file to match your environment configuration, then run ```composer update && npm install && npm run build && php artisan migrate:fresh --seed && php artisan key:generate && php artisan storage:link```.
## Usage
Run ```php artisan serve``` and visit http://localhost:8000 (or whichever port ```artisan``` serves on) on your browser.

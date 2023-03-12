# Depression
An expert system aimed to help diagnose depression and similar disorders, which I wrote for my thesis. Supports forward chaining with naive bayes probabilistic classifier.

![image](https://user-images.githubusercontent.com/47256917/224542705-9163a030-b322-4709-86da-3b108c12fa16.png)
# Installation
Create a database and edit the ```.env``` file to match your environment configuration, then run ```composer update && php artisan migrate:fresh --seed```.
# Usage
Run ```php artisan serve``` and visit http://localhost:8000 (or whichever port ```artisan``` serves on) on your browser.

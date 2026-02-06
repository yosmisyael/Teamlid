<h1 align="center" id="title">Teamable</h1>

<p align="center">
    <img src="https://socialify.git.ci/yosmisyael/Teamlid/image?custom_description=A+Modern+Open-Source+Human+Capital+Management+Solution+for+Everyone.&description=1&logo=https%3A%2F%2Fraw.githubusercontent.com%2Fyosmisyael%2FTeamlid%2F492ff6c182110b5d7ba83585c657388cb7dad17e%2Fpublic%2Flogo.svg&name=1&owner=1&theme=Light" alt="project-description" >
</p>

<p id="description">A Modern Open-Source Human Capital Management Solution for Everyone.</p>

<h2>Project Screenshots:</h2>

<img src="https://raw.githubusercontent.com/yosmisyael/Teamlid/refs/heads/main/docs/page_teamlid_home.png" alt="project-screenshot" width="412.75" height="230.75">

<img src="https://github.com/yosmisyael/Teamlid/blob/main/docs/page_teamlid_company_profile.png?raw=true" width="412.75" height="230.75">

<img src="https://github.com/yosmisyael/Teamlid/blob/main/docs/page_teamlid_overview.png?raw=true" alt="project-screenshot" width="412.75" height="230.75">

<img src="https://github.com/yosmisyael/Teamlid/blob/main/docs/page_teamlid_company_profile.png?raw=true" alt="project-screenshot" width="412.75" height="230.75">
  
<h2>Features</h2>

Here're some of the project's best features:

*   Employee Management
*   Attendance Monitoring
*   Automated Payrolls Processing
*   Leave Management
*   Employee Access App
*   Payroll Slip and Emailing
*   Department Management
*   Job & Position Management
*   Salary Management

<h2>Installation Steps:</h2>

<p>1. Get the source code</p>

```
git clone https://github.com/yosmisyael/teamable.git
```

<p>2. Install composer dependencies</p>

```
composer install
```

<p>3. Install npm dependencies</p>

```
npm install
```

<p>4. Set configuration (database mail server)</p>

```
cp .env.example .env
```

<p>5. Generate app key</p>

```
php artisan key:generate
```

<p>6. Run db migrations</p>

```
php artisan migrate
```

<p>7. Link storage path</p>

```
php artisan storage:link
```

<p>8. Compile the assets</p>

```
npm run dev
```

<p>9. Run the application</p>

```
php artisan serve
```

<h2>License:</h2>

This project is licensed under the GNU GPL v3

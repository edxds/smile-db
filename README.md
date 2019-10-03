<p align="center">
    :-)db
</p>
<p align="center">
    <small>a php assignment</small>
</p>

## about
### important sql commands
- `show databases`
- `show tables`
- `show columns from <table_name>`

### architecture/organization overview
php pages are in root. most of the work is done in the home (index.php) page.
it only communicates with the `MainViewModel` class. this is done to promote
separation of concerns (_kinda_, this is just a school assignment).

the presentational logic is done in the viewmodels, while the 'model' logic is done
in the `MySqlHost` class. the viewmodel communicates with the model, while the page
gets its state form the viewmodel class. 

the viewmodel class only exposes the
specific fields the view needs, and in read-only form. actions, such as next page,
are expressed as URLs.

## todo
- [ ] write a better damn README (sorry)
- [ ] add css styling to match design file 

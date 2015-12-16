<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<?php
require 'capybara/lib/dsl'
//require 'capybara-webkit'

include Capybara::DSL
Capybara.current_driver = :webkit
Capybara.app_host = "http://www.google.com"
page.visit("/")
puts(page.html)

?>
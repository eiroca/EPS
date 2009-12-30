EIROCA PORTAL SYSTEM - Framework to build Mobile site
Copyright (C) 2003-2006 eIrOcA - Enrico Croce & Simona Burzio

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.

The latest version of EIROCA PORTAL SYSTEM can be obtained from: http://www.eiroca.net


PREREQUISITE
============
In order to run EPS you need a working copy of Apache 2.x with PHP 4.x or PHP 5.x correctly installed.
PHP must have the GD extension enabled.

INSTALLATION
============
Copy the contents of the zip file in the the Apache's htdocs directory.
Run a Web browser and type http://apache_domain/lib/eps/setup.php, you should see something like:

Checking...
GD Library ... OK v. 2
testing directory ...
Portal found(s):
test_mobile
test_web

You have finished to install the EPS portal framework, you can test a Web portal typing http://apache_domain/test_web and the mobile portal using http://apache_domain/test_mobile.

DEVELOPING PORTAL
=================
Currently no docs is available :(
See the test_xxx directory to see how the framework works.
Just remember that for Web portals each page is a subdirectory inside the "pages"" directory and after adding or removing a subdirectory you need to run the setup.php (or delete the portal/data/index.ini).

ADVICES
=======
In real portals change the eps_config.inc of your portals in order to use logs, var directory.
Don't to forget to make /lib and data, logs directory not public available (e.g. changing permission or .htaccess file).

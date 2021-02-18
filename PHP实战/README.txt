This is the collection of source code for the book PHP In Action. It has one
directory per chapter. 

All chapters expect 9, 10, 11 (Dagfinn Reiersøl)
-----------------------------------------------------------

These directories contain the following types of files:

1) Each formal, numbered listing has its own file. Most of them are PHP code, but
there are also some HTML, XML and Javascript files.

2) Some "odd" files are included containing unnumbered code examples from the book.

3) Larger examples are located in subdirectories of the chapter directories. These
are (sometimes slightly revised) original versions from which the listings were
taken. They span several listings and code examples from the book. This means 
that there is a fair amount of duplicatin between these and the listing
files. Unit tests for all of them are also included.

The unit tests, reflecting my personal preference, are written to be run from the
command line using the PHP CLI binary. For example:

$ php Menutest.php

chapters 9, 10 and 11 (Marcus Baker)
------------------------------------

These chapters have larger, more extended examples. This makes it harder to run the 
tests in isolation. They are more dependent on outside resources including Mysql.



-- Dagfinn Reiersøl

# Greeklish wordlist generator
This ugly ass code, takes as an input a greek wordlist and produces a greeklish wordlist. The product of this code is intended to crack passwords for our pentester friends. There are many projects that do that out there like https://github.com/iam1980/greeklish-wordlist but those do only simple character substitutions which was not enough for me. People write words in very weird ways.

Goals:
- Find every conceivable way that someone might write a greek work in greeklish and add them all to the final wordlist.
- Create a simple wordlist, no enrichment is done to the final words. (Capitalize first later, replace a with @, put 1 or ! in the end, add 2020 etc). Tools like john the ripper and hashcat do that very well on the fly, no need to fill my hard disks with pregenerated lists.

Usually my code is much prettier, but alas my time is limited now, so  I don't have time to make it pretty - nor I care to - it just works. Hopefully you will never have to run it, I provide a link to the generated wordlist below.

How to run
-----------
Install leveldb:
`sudo apt-get install libleveldb-dev php-dev`
Then follow the instructions here to install php-leveldb: https://github.com/reeze/php-leveldb.git

Then simply edit the first line with your wordlist:

`$inputWordlist = "gr_utf8.txt";`
Then run:
`php run.php`
Then let if finish. It will produce a file named output.gz

To extract it:
`gunzip output.gz`

This file contains all permutations and a small percentage of words with greek characters. To clear them out:

`grep -v -P "[^\x00-\x7F]" output > output_clean`

The process would be much faster using hashmap in memory, but the wordlist was pretty big my RAM was not enough, so I resorted to leveldb which is slower, but has very low memory requirements for any size wordlist.

Example wordlist
---------------

Input:
- gr_utf8.txt from this project https://github.com/iam1980/greeklish-wordlist (also included in the repo). This is probably a very reasonable greek wordlist from a dictionary or something. But because people write lots of stuff that aren't in dictionaries, I added the 2 below sources. 
- A rip of the entire site slang.gr, every definition, comment etc, greek words written in the website
- A rip of skroutz.gr reviews like: https://www.skroutz.gr/s/20060269/Apple-iPhone-11-64GB-Black.html#reviews

Example Output
------------
You can download the generated wordlist here: https://nikos.glikis.net/files/output_final.gz
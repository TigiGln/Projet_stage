#!/usr/bin/perl -w
use strict;
use warnings;
use open ':std', ':encoding(UTF-8)';

# vérifie si l'utilisateur a précisé le fichier
if (!$ARGV[0])
{
	print "Argument file not found!\n$!" and die;
}

my $file = $ARGV[0];
my @listePmid = ();

if(!-e $file) 
{
   	print  "file not valid \n";
}
else
{
	open(my $folder, "<", $file);

	while(defined(my $line = <$folder>)) 
	{
	   chomp $line;
	   push @listePmid, $line;
	}
	
}
my $first = shift @listePmid;
print $first . "\n";

#!/usr/bin/perl -w
use strict;
use warnings;

# LWP est une bibliothèque permettant de lire les données en HTTP
use LWP::Simple;
use LWP::UserAgent;

# vérifie si l'utilisateur a précisé le GeneID
if ( !$ARGV[0] ){
    print "Argument PubmedID not found!\n$!" and die;
}
my $pubmedid = $ARGV[0];

# construction de la requête de recherche
my $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term=';

# récupération du résultat comme si vous l'aviez ouvert dans votre navigateur
my $output = get($base.$pubmedid);
$output =~ s/[\r\n] +/ /g;
my $WebEnv = $1 if ($output =~ m/<WebEnv>([^"]+)<\/WebEnv>/);
if($WebEnv eq '')
{
 print "Error no WebEnv returned!";
} else
{
 print $WebEnv;
}

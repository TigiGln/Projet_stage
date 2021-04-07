#!/usr/bin/perl -w
use strict;
use warnings;
use open ':std', ':encoding(UTF-8)';

# LWP est une bibliothèque permettant de lire les données en HTTP
use LWP::Simple;
use LWP::UserAgent;

# vérifie si l'utilisateur a précisé le GeneID
if ( !$ARGV[0] )
	{
		print "Argument PubmedID not found!\n$!" and die;
	}
#else
#	{
#		print $ARGV[0] . "\n";
#	}
my $pubmedid = $ARGV[0];

# construction de la requête de recherche
my $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term=';

# récupération du résultat comme si vous l'aviez ouvert dans votre navigateur
my $search = get($base.$pubmedid);
#print "output: " . $search . "\n";
#print "\n";

#$output =~ s/[\r\n] +/ /g;

#print "output regex: " . $output . "\n";
my $WebEnv = $1 if ($search =~ m/<WebEnv>([^"]+)<\/WebEnv>/);
#print $WebEnv . "\n";
#if($WebEnv eq '')
#	{
#	 print "Error no WebEnv returned!";
#	} 
#else
#	{
#	 print $WebEnv;
#	}
# construction de la requête de recherche
my $base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $WebEnv;
my $url = $base1 . "&usehistory=y&term=" . $pubmedid;

# récupération du résultat comme si vous l'aviez ouvert dans votre navigateur
my $output = get($url);
#print "$output \n";
$output =~ s/[\r\n] / /g;
$output =~ s/'//g;

my $title = "";
if ($output =~ m/<ArticleTitle>(.+?)<\/ArticleTitle>/)
	{
		$title = $1;
	}
$title =~ s/<.+?>//g;
my $authorList = '';
my $authors = '';
if ($output =~ /<AuthorList[^>]*>(.+?)<\/AuthorList>/g)
	{
		#print $output;
		$authors = $1;
	}
while ($authors =~ /<Author[^>]*>(.+?)<\/Author>/g)
	{
		my $tempString = $1;
		#print $tempString . "\n";
		my $foreName = "";
		my $name = "";
		if ($tempString =~ m/<Initials>(.+?)<\/Initials>/)
			{
				$foreName = $1;
			}
		if ($tempString =~ m/<LastName>(.+?)<\/LastName>/)
			{
				$name = $1;
			}

		if(!$authorList eq '')
			{
				$authorList .= ", ";
			}
		$authorList .= $name . " " . $foreName;
	}
my $doi = "";
if($output =~ m/="doi"[^>]*>(.+?)</)
	{
		$doi = $1;
	}
my $journal = ""; 
if ($output =~ m/<Title>(.+?)<\/Title>/)
	{
		$journal = $1;
	}
my $abstract = "";
if ($output =~ m/<Abstract>(.+?)<\/Abstract>/)
	{
		$abstract = $1
	}
my $abstractList = "";
while ($abstract =~ /<AbstractText[^>]*>(.+?)<\/AbstractText>/g)	
	{
		$abstractList .= $1 . "\n";		
	}

$abstractList =~ s/<.+?>//g;
#$abstract =~ s/[\r\t\n]//g;
print "PMID: " . $pubmedid . "\n";
print "DOI: " . $doi . "\n\n";
print "Titre: " . $title . "\n\n";
print "Auteurs: \n" . $authorList . "\n";
print "Journal: " . $journal . "\n\n";
print "Abstract: \n" . $abstractList . "\n";

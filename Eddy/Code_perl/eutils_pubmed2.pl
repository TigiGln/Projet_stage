#!/usr/bin/perl -w
use strict;
use warnings;

# LWP est une bibliothèque permettant de lire les données en HTTP
use LWP::Simple;
use LWP::UserAgent;

# vérifie si l'utilisateur a précisé le GeneID
if ( !$ARGV[0] ){
    print "Argument WebEnv not found!\n$!" and die;
}
my $WebEnv = $ARGV[0];

# vérifie si l'utilisateur a précisé le pattern de locus_tag
if ( !$ARGV[1] ){
    print "Argument PubmedID not found!\n$!" and die;
}
my $pubmedID = quotemeta $ARGV[1];

# construction de la requête de recherche
my $base = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $WebEnv;
my $url = $base . "&usehistory=y&term=" . $pubmedID;

# récupération du résultat comme si vous l'aviez ouvert dans votre navigateur
my $output = get($url);
print $output. "\n";
$output =~ s/[\r\n] / /g;
$output =~ s/'//g;


my $title = $1 if ($output =~ m/<ArticleTitle>(.+?)<\/ArticleTitle>/);

if(!$title eq '')
{
 my $authorList = '';
 my $authors = '';
 $authors = $1 if ($output =~ /<AuthorList[^>]*>(.+?)<\/AuthorList>/g);
 while ($authors =~ /<Author[^>]*>(.+?)<\/Author>/g)
 {
  my $tempString = $1;

  #print $tempString . "\n";

  my $name = $1 if ($tempString =~ m/<LastName>(.+?)<\/LastName>/);
  my $initials = $1 if ($tempString =~ m/<Initials>(.+?)<\/Initials>/);

  if(!$authorList eq '')
  {
   $authorList .= ", ";
  }
  $authorList .= $name . " " . $initials;
 }

 my $journal = $1 if ($output =~ m/<Title>(.+?)<\/Title>/);
 my $volume = $1 if ($output =~ m/<Volume>(.+?)<\/Volume>/);
 my $issue = $1 if ($output =~ m/<Issue>(.+?)<\/Issue>/);
 my $page = $1 if ($output =~ m/<MedlinePgn>(.+?)<\/MedlinePgn>/);
 my $journalDetails = $journal;
 if(!$volume eq '')
 {
  $journalDetails .= ", " . $volume;
 }
 if(!$issue eq '')
 {
  $journalDetails .= "(" . $issue . ")";
 }
 if(!$page eq '')
 {
  $journalDetails .= ":" . $page;
 }
 my $doi = "NULL";
 $doi = $1 if($output =~ m/="doi"[^>]*>(.+?)</);
 my $year = "NULL";
 $year = $1 if ($output =~ m/<PubDate>.+?<Year>(.+?)<\/Year>/);

 print $doi . "\t" . $title . "\t" . $authorList . "\t" . $journalDetails . "\t" . $year;

} else
{
 print "Error no Pubmed details returned!";
}


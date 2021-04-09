#!/usr/bin/perl -w
use strict;
use warnings;
use open ':std', ':encoding(UTF-8)';
use Data::Dumper;

# LWP est une bibliothèque permettant de lire les données en HTTP
use LWP::Simple;

sub search_articles
{
	#création des variable
	my @listePmid;
	my %dico_article_descript;
	my $output = "";

	# vérifie si l'utilisateur a précisé le fichier
	if (!$ARGV[0])
	{
		print "Argument file not found!\n$!" and die;
	}

	my $pubmedids = $ARGV[0];

	if(!-e $pubmedids) 
	{
	   	print  "file not valid \n";
	}
	else
	{
		open(IN, "<", $pubmedids) || die "Impossible d'ouvrir le fichier: $pubmedids\n";

		while(defined(my $line = <IN>)) 
		{
			chomp $line;
			if ($line ne "")
			{
			   	push @listePmid, $line;
			}
		}
		close($pubmedids)
	}

	#print Dumper(@listePmid) . "\n";die;
	foreach my $pubmedid (@listePmid)
	{
		# construction de la requête de recherche
		my $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term=';

		# récupération du résultat comme si vous l'aviez ouvert dans votre navigateur
		my $search = get($base.$pubmedid);

		my $WebEnv = "";
		if ($search =~ m/<WebEnv>([^"]+)<\/WebEnv>/)
		{
			$WebEnv = $1;
		}
		if($WebEnv eq '')
		{
		 print "Error no WebEnv returned!";
		} 
		# construction de la requête de recherche
		my $base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $WebEnv;
		my $url = $base1 . "&usehistory=y&term=" . $pubmedid;

		# récupération du résultat comme si vous l'aviez ouvert dans votre navigateur
		$output = get($url);
		$output =~ s/[\r\n]/ /g;
		$output =~ s/'//g;
		#print $output; die;

	######################################################################################################################################################################################
		#récupération des éléments de l'article
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
			$authors = $1;
		}
		while ($authors =~ /<Author[^>]*>(.+?)<\/Author>/g)
		{
			my $tempString = $1;
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
			
			$abstractList .= $1;
					
		}

		$abstractList =~ s/<.+?>//g;

		my $years = "";
		if($output =~ m/<PubDate>(.+?)<\/PubDate>/)
		{	
			if ($1 =~ m/<Year>(.+?)<\/Year>/)
			{
				$years = $1;
			}
			
		}
	#####################################################################################################################
		my @list_descript_article = ($doi, $title, $authorList, $journal, $abstractList, $years);
		#print Dumper(\@list_descript_article);
		$dico_article_descript{$pubmedid} = \@list_descript_article;
		#print %dico_article_descript;
		#print "PMID: " . $pubmedid . "\n";
		#print "DOI: " . $doi . "\n\n";
		#print "Titre: " . $title . "\n\n";
		#print "Auteurs: \n" . $authorList . "\n\n";
		#print "Journal: " . $journal . "\n\n";
		#print "Resume: \n" . $abstractList . "\n\n";
		#print "Annee: " . $years . "\n\n";
	}
return %dico_article_descript
}

sub main
{
	my (%dico) = search_articles();
	print Dumper(\%dico);
}
	
main() unless caller;


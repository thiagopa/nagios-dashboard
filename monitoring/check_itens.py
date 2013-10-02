#-*- coding: utf-8 -*-
import urllib2
from BeautifulSoup import BeautifulSoup

from optparse import OptionParser
 
# CONSTANTS FOR RETURN CODES UNDERSTOOD BY NAGIOS
# Exit statuses recognized by Nagios
UNKNOWN = -1
OK = 0
WARNING = 1
CRITICAL = 2
 
# TEMPLATE FOR READING PARAMETERS FROM COMMANDLINE
parser = OptionParser()
parser.add_option("--host", dest="host", default='some.service.com.br', help="Host name")
(options, args) = parser.parse_args()
 

URL_LOGIN = "https://%s/login?emailAddress=someone@gmail.com&password=1234567890" % (options.host)

try :

	request = urllib2.Request(url=URL_LOGIN)
	response = urllib2.urlopen(request)

	soup = BeautifulSoup(response.read())

	token = soup.find("authtoken").string

	URL_ITEMS = "https://%s/items?authToken=%s" % (options.host,token)
	
	request = urllib2.Request(url=URL_ITEMS)
	response = urllib2.urlopen(request)
	
	soup = BeautifulSoup(response.read())
	
	entitlements = [e for e in soup.find("items").contents if e != '\n']
	
	print "Login OK, Listou %d items" % len(entitlements)
	raise SystemExit, OK
except Exception as e:
	print str(e)
	raise SystemExit, CRITICAL


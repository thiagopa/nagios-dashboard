#-*- coding: utf-8 -*-
from mako.template import Template
import os
import urllib2
from BeautifulSoup import BeautifulSoup

URL='http://localhost/status/statusXML.php'
full_path = os.path.realpath(__file__)

class HostInfo :
	def __init__(self,name,status,message) :
		self.name = name
		self.status = status
		self.message = message


def getHosts() :
        hosts = []
        request = urllib2.Request(url=URL)
        response = urllib2.urlopen(request)
        soup = BeautifulSoup(response.read())
	
	for host in soup.findAll('service') :
		host_name = host.host_name.string
                host_status = host.current_state.string
		host_message = host.plugin_output.string
		hostInfo = HostInfo(host_name,host_status,host_message)
                hosts.append(hostInfo)
        return hosts


def renderTemplate(file):
    template = Template(filename = file, output_encoding = 'utf-8')
    return template.render(hosts=getHosts())

def application(environ, start_response):
    path = os.path.dirname(full_path) + '/table.html'
    template = renderTemplate(path)
    start_response('200 OK', [('Content-Type', 'text/html'),])
    return [template]  

      
      

#! /usr/bin/python
#---------------------------------------------------------Import Modules----------------------------------------------------------------------#


try:
    import requests
except ImportError as exc:
    print("Error: failed to import settings module ({})".format(exc))

def query(wt="json", indent="true"):

    '''Perform query operations on the solr server.'''
    
    url = "http://192.168.111.190:8983/solr/news/select"
    payload = {}
    payload['q']="headline:Obama"
    payload['wt'] = wt
    payload['indent']=indent
    payload['fl']="headline"

    r=requests.get(url, params=payload)
    if(r.status_code != 200):
        print "Error connecting to url ",r.url,". Status code returned was : ",r.status_code
    else:
        print r.json()

query()
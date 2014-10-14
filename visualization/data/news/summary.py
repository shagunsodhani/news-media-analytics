import json


f_valid = open("valid_url.json",'r')
f_invalid = open("invalid_url.json",'r')
f_null = open("null_url.json",'r')

f = open("summary.csv",'w')

valid_line = (f_valid.readlines()[8]).strip('\n')
invalid_line = (f_invalid.readlines()[8]).strip('\n')
null_line = (f_null.readlines()[8]).strip('\n')

d_valid_url = json.loads(valid_line)
d_invalid_url = json.loads(invalid_line)
d_null_url = json.loads(null_line)

for x in d_valid_url:
	f.write(str(x['sourceId'])+"-valid,"+str(x['count(*)'])+"\n")

for x in d_invalid_url:
	f.write(str(x['sourceId'])+"-invalid,"+str(x['count(*)'])+"\n")

for x in d_null_url:
	f.write(str(x['sourceId'])+"-null,"+str(x['count(*)'])+"\n")

f.close()

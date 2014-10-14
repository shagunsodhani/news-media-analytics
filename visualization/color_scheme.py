import json    
import random
r = lambda: random.randint(0,255)

d_src = {}

f = open("mapping.json",'r')
f_output = open("color_scheme.txt",'w')
line = f.readlines()[8]
line = line.strip('\n')

d = json.loads(line)

for x in d:
	if x['sourceId'] not in d_src:
		d_src[x['sourceId']] = x['sourceId']

l = len(d_src)

d_color = {}
count = 0
while count != (l+5):
	color = '#%02X%02X%02X' % (r(),r(),r())
	if color not in d_color:
		d_color[count] = color
		count += 1

count = 0
for x in d_src:
	d_src[x] = "\""+str(d_src[x])+"\": \""+d_color[count]+"\","
	count += 1

for x in d_src:
	f_output.write(d_src[x]+"\n")

d_src["valid"] = "\"valid\": \""+d_color[count]+"\","
d_src["invalid"] = "\"invalid\": \""+d_color[count+1]+"\","
d_src["null"] = "\"null\": \""+d_color[count+2]+"\""

f_output.write(d_src["valid"]+"\n")
f_output.write(d_src["invalid"]+"\n")
f_output.write(d_src["null"]+"\n")

f_output.close()

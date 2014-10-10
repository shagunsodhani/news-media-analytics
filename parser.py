try:
	import db
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

try:
	import time
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

try:
	import datetime
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

try:
	import hashlib
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))


MOD = 10000

def date_to_timestamp(stime):
	stime = stime.split(' ')
	date = stime[0]
	temp = date.split("/")
	a = []
	a.append(int(temp[2]))
	a.append(int(temp[0]))
	a.append(int(temp[1]))
	date = stime[1].split(':')
	for i in date:
		a.append(int(i))
	a = datetime.datetime(a[0], a[1], a[2], a[3], a[4]).timetuple() 
	return time.mktime(a)
	
@profile
def parse():

	count = 0
	urlId = 0
	headlineId = 0
	timeCombId = 0
	timeId = 0
	timeCombId = 0 
	stime_curr = ""
	stime_curr_timestamp = 0
	etime_curr = ""
	etime_curr_timestamp = 0

	timeCombmap = {}
	Time = {}
	headline_sha1 = {}
	url_sha1 = {}

	sql_default_headline = "INSERT INTO headline (headlineId, headline) VALUES "
	sql_default_url = "INSERT INTO url (urlId, url) VALUES "
	sql_default_time = "INSERT INTO time (timeId, time) VALUES "
	sql_default_mapping = "INSERT INTO mapping (urlId, headlineId, timeCombId, sourceId) VALUES "
	sql_default_timeComb = "INSERT INTO timeComb (timeCombId, startDate, endDate) VALUES "

	sql_headline = sql_default_headline
	sql_url = sql_default_url
	sql_time = sql_default_time
	sql_mapping = sql_default_mapping
	sql_timeComb = sql_default_timeComb

	flag_url = 0
	flag_headline = 0
	flag_time = 0
	flag_mapping = 1
	flag_timeComb = 0

	parser = open("Data/1.csv", "r")

	conn = db.connect('news')
	cursor=conn.cursor()

	for i in parser:

		if (count%MOD  == 0):
			sql_headline = sql_default_headline
			sql_url = sql_default_url
			sql_time = sql_default_time
			sql_mapping = sql_default_mapping
			sql_timeComb = sql_default_timeComb
			
			flag_url = 0
			flag_headline = 0
			flag_time = 0
			flag_timeComb = 0

		line = i.split(",")
		temp_headline = str( (line[1]).replace("\"","\\\"").replace("\'","\\\'").strip() )
		temp_url = str( (line[5]).replace("\"","\\\"").replace("\'","\\\'").strip() )
		
		temp_url_sha1 = hashlib.sha1(temp_url).hexdigest()
		temp_headline_sha1 = hashlib.sha1(temp_headline).hexdigest()

		if temp_url_sha1 not in url_sha1.keys():
			flag_url = 1
			urlId+=1
			url_sha1[temp_url_sha1] = str(urlId)
			sql_url+="(\""+str(urlId)+"\" , \""+temp_url+ "\"), "

		if temp_headline_sha1 not in headline_sha1.keys():
			flag_headline = 1
			headlineId+=1
			headline_sha1[temp_headline_sha1] = str(headlineId)
			sql_headline+="(\""+str(headlineId)+"\" , \""+temp_headline + "\"), "
		
		stime = str(line[2]).strip()
		if stime!=stime_curr:	
			stime_curr = stime
			stime = int(date_to_timestamp(stime))
			stime_curr_timestamp = stime 
			if stime not in Time.keys() :
				timeId+=1
				flag_time = 1
				Time[stime]=str(timeId)
				sql_time+= "(\""+str(timeId)+"\" , \"" + str(stime) + "\"), "
				
		else:
			stime=stime_curr_timestamp

		etime = str(line[3]).strip()
		if(etime!=etime_curr):		
			etime_curr = etime
			etime = int(date_to_timestamp( etime ))
			etime_curr_timestamp = etime
			if etime not in Time.keys() :
				timeId+=1
				flag_time = 1
				Time[etime]=str(timeId)
				sql_time+= "(\""+str(timeId)+"\" , \"" + str(etime) + "\"), "
		else:
			etime=etime_curr_timestamp

		key = str(stime)+str(etime)
		if key not in timeCombmap.keys():
			timeCombId+=1
			flag_timeComb = 1 
			timeCombmap[key] = str(timeCombId)
			sql_timeComb+= "(\""+str(timeCombId)+"\", \""+Time[stime]+"\", \""+Time[etime]+"\"), "

		temp_sourceId = str(line[4]).strip()

		sql_mapping+= "(\""+url_sha1[temp_url_sha1] +"\" , \"" + headline_sha1[temp_headline_sha1] + "\", \"" + timeCombmap[key] + "\", \" " + temp_sourceId + "\"), "	

		count+=1	
		if (count%MOD  == 0):
			if(flag_url == 1):
				sql_url = sql_url[:-2]
				db.write(sql_url, cursor, conn)

			if(flag_headline == 1):
				sql_headline = sql_headline[:-2]
				db.write(sql_headline, cursor, conn)

			if(flag_time == 1):
				sql_time = sql_time[:-2]
				db.write(sql_time, cursor, conn)

			if(flag_timeComb == 1):
				sql_timeComb = sql_timeComb[:-2]
				db.write(sql_timeComb, cursor, conn)

			if(flag_mapping == 1):
				sql_mapping = sql_mapping[:-2]	
				db.write(sql_mapping, cursor, conn)
			
			print count," lines inserted into the DB"

	if(flag_url == 1):
		sql_url = sql_url[:-2]
		db.write(sql_url, cursor, conn)
	if(flag_headline == 1):
		sql_headline = sql_headline[:-2]
		db.write(sql_headline, cursor, conn)
	if(flag_time == 1):
		sql_time = sql_time[:-2]
		db.write(sql_time, cursor, conn)
	if(flag_timeComb == 1):
		sql_timeComb = sql_timeComb[:-2]
		db.write(sql_timeComb, cursor, conn)
	if(flag_mapping == 1):
		sql_mapping = sql_mapping[:-2]	
		db.write(sql_mapping, cursor, conn)

	print count," lines inserted into the DB"

	cursor.close()
	# print sql_headline
	# print sql_urls	
	# print sql_time
	# print sql_source
	# print sql_timeComb		

parse()
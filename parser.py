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
	return time.mktime(datetime.datetime.strptime(stime, "%m/%d/%Y %H:%M").timetuple())

@profile
def parse():
	count = 0
	url_sha1 = {}
	urlId = 0
	timeCombId = 0
	timeId = 1
	timeCombId = 1
	combId_sha1 = []  
	timeCombmap = []
	Time = {}
	stime_curr = ""
	stime_curr_timestamp = 0
	etime_curr = ""
	etime_curr_timestamp = 0

	sql_default_headline = "INSERT INTO headline (urlId, headline) VALUES "
	sql_default_urls = "INSERT INTO urls (urlId, url) VALUES "
	sql_default_time = "INSERT INTO time (timeId, time) VALUES "
	sql_default_source = "INSERT INTO source (urlId, sourceId, timeCombId) VALUES "
	sql_default_timeComb = "INSERT INTO timeComb (timeCombId, startDate, endDate) VALUES "

	sql_headline = sql_default_headline
	sql_urls = sql_default_urls
	sql_time = sql_default_time
	sql_source = sql_default_source
	sql_timeComb = sql_default_timeComb

	flag_urls = 0
	flag_time = 0
	flag_source = 0
	flag_timeComb = 0

	parser = open("1.csv", "r")

	conn = db.connect('news')
	cursor=conn.cursor()

	for i in parser:
		if (count%MOD  == 0):
			sql_headline = sql_default_headline
			sql_urls = sql_default_urls
			sql_time = sql_default_time
			sql_source = sql_default_source
			sql_timeComb = sql_default_timeComb
			flag_urls = 0
			flag_time = 0
			flag_source = 0
			flag_timeComb = 0

		line = i.split(",")
		temp_headline = str( (line[1]).replace("\"","").replace("\'","").strip() )
		temp_url = str( (line[5]).replace("\"","").replace("\'","").strip() )
		temp_url_sha1 = hashlib.sha1(temp_url).hexdigest()
		if temp_url_sha1 not in url_sha1.keys():
			flag_urls = 1
			urlId+=1
			url_sha1[temp_url_sha1] = str(urlId)
			sql_urls+="(\""+str(urlId)+"\" , \""+temp_url+ "\"), "
			sql_headline+="(\""+str(urlId)+"\" , \""+temp_headline + "\"), "
		
		stime = str(line[2]).strip()
		if stime!=stime_curr:	
			stime_curr = stime
			stime = int(date_to_timestamp(stime))
			stime_curr_timestamp = stime 
			if stime not in Time.keys() :
				flag_time = 1
				Time[stime]=str(timeId)
				sql_time+= "(\""+str(timeId)+"\" , \"" + str(stime) + "\"), "
				timeId+=1
		else:
			stime=stime_curr_timestamp

		etime = str(line[3]).strip()
		if(etime!=etime_curr):		
			etime_curr = etime
			etime = int(date_to_timestamp( etime ))
			etime_curr_timestamp = etime
			if etime not in Time.keys() :
				flag_time = 1
				Time[etime]=str(timeId)
				sql_time+= "(\""+str(timeId)+"\" , \"" + str(etime) + "\"), "
				timeId+=1
		else:
			etime=etime_curr_timestamp

		temp_sourceId = str(line[4]).strip()
		temp_sourceId_sha1 = hashlib.sha1(temp_url+temp_sourceId).hexdigest()

		if temp_sourceId_sha1 not in combId_sha1:
			flag_source = 1
			combId_sha1.append(temp_sourceId_sha1)
			sql_source+= "(\""+url_sha1[temp_url_sha1] +"\" , \"" + temp_sourceId + "\", \"" + str(timeCombId) + "\"), "	
		
		key = str(stime)+str(etime)
		if key not in timeCombmap:
			flag_timeComb = 1 
			timeCombmap.append(key)
			sql_timeComb+= "(\""+str(timeCombId)+"\", \""+Time[stime]+"\", \""+Time[etime]+"\"), "
			timeCombId+=1

		count+=1	
		if (count%MOD  == 0):
			
			if(flag_urls == 1):
				sql_urls = sql_urls[:-2]
				db.write(sql_urls, cursor, conn)
				sql_headline = sql_headline[:-2]
				db.write(sql_headline, cursor, conn)
			
			if(flag_time == 1):
				sql_time = sql_time[:-2]
				db.write(sql_time, cursor, conn)

			if(flag_timeComb == 1):
				sql_timeComb = sql_timeComb[:-2]
				db.write(sql_timeComb, cursor, conn)

			if(flag_source == 1):
				sql_source = sql_source[:-2]	
				db.write(sql_source, cursor, conn)

	if(flag_urls == 1):
		sql_urls = sql_urls[:-2]
		db.write(sql_urls, cursor, conn)
		sql_headline = sql_headline[:-2]
		db.write(sql_headline, cursor, conn)

	if(flag_time == 1):
		sql_time = sql_time[:-2]
		db.write(sql_time, cursor, conn)

	if(flag_timeComb == 1):
		sql_timeComb = sql_timeComb[:-2]
		db.write(sql_timeComb, cursor, conn)

	if(flag_source == 1):
		sql_source = sql_source[:-2]	
		db.write(sql_source, cursor, conn)

	cursor.close()
	# print sql_headline
	# print sql_urls	
	# print sql_time
	# print sql_source
	# print sql_timeComb		

parse()
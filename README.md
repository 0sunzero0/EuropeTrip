# 우리가 떠나야 할 EU 🌴
✈️ All about Europe, especially Hotels, Restaurants, and tourist attractions in one search
## 1️⃣ 우리가 떠나야 할 EU란?
### 소개
- 기술의 발전으로 전세계를 자유롭게 여행할 수 있는 시대가 되었습니다. 그러나 너무 방대한 정보들과 선택지들이 범람하는 탓인지, 여행을 계획하는 이들에게 정보 접근에 대한 편의성 만큼 불편함도 적지 않게 있다는 것을 알게 되었습니다.
- 여기에 주목하여 세계로의 여행, 특히 유럽으로 가기 위해 필수적인 정보들인 숙박시설, 각 나라의 도시별 여행지, 인근 식당과 공항 정보 등을 시중에 나와 있는 다른 서비스들과 차별화되게 검색하여 사용자에게 보여줄 수 있는 서비스를 만들어 볼 것을 2020년도 1학기 Database system 과목 Team Project로 선정하여 진행하게 되었습니다. 
  - 기존에 존재하는 B 사이트와 T 사이트는 광고가 많아 이용하기 불편하기도 하고, UI 특성상 이용자가 원하는 정보를 빠르고 쉽게 찾기가 힘듦.
- 사용자들에게 기존과 차별화된 사용자 경험을 제공하고 여행 목적지와 관련된 숙식, 명소, 공항 정보 등 모든 것을 검색 한 번으로 직관적인 여행 계획 수립에 도움을 줄 수 있는 웹사이트를 구축했습니다. 
- 현재 전세계적인 코로나 팬데믹 사태로 인해 유럽 여행을 가고자 하였으나 불가피하게 취소할 수 밖에 없었던 사람들에게 소소한 만족과 경험을 대신하여 줄 것도 기대해 봅니다.
### 진행기간
- 진행 기간 :  2020.03.23~2020.06.22
### 목적
- 빠른 검색
  - 여러 결과를 한번에 보고, 지도에서 곧바로 확인
- 복잡하지 않은 기능
  - 간단한 옵션 및 필터 선택
- 사용자 중심 UI/UX
  - 심플하고 직관적인 디자인
  - 광고없는 쾌적한 searching

## 2️⃣ 결과
![Output1](https://user-images.githubusercontent.com/29566893/127650332-0b31b9a9-2f6b-4cb6-bd15-efe05dbc0939.png)
![Output2](https://user-images.githubusercontent.com/29566893/127650470-507befba-5ced-4c14-af73-9f3d9b7d3651.png)
[데모 영상 주소](https://www.youtube.com/watch?v=xs_1EB2tig4)
### 제공하고자 하는 서비스
![Service](https://user-images.githubusercontent.com/29566893/127650023-6e2e1790-38ea-4d46-90ad-135c97ad5cb3.png)
### 본 검색 서비스의 특징
- 검색 옵션을 선택 가능
  - 도시이름 ,나라이름 중 하나를 선택하여 주변 관광 정보들을 한번에 검색 가능
- 결과 출력 옵션을 선택 가능
  - 여행지, 호텔, 레스토랑들을 필터를 적용하여 검색시 가격, 식당 종류, 호텔 인원 등을 선택할 수 있는 옵션 기능 추가

## 3️⃣ 개발 환경 및 사용 데이터
- MySQL Workbench, Jetbrain Datagrip, Mac Z-shell terminal
- Amazon Web Service EC2 Linux AMI
- Apache/2.2.34(Unix), mysql ver.14.14 Distrib 5.5.62, for Linux, PHP 5.3.29 (cli)
<br>
- (Hotel) 515k Hotels Reviews Data in Europe
- (Restaurant) Restaurants Info for 31 Euro-cities
- (Tourist) Tourist Attractions of each cities in EU

## 4️⃣ Database
### Database Schema
![DB Schema](https://user-images.githubusercontent.com/29566893/127652366-50bc44f5-b226-41ad-91e1-272d859f0e13.png)

### Database Tables
- 총 개수 : 24개
- 전부 Normalization 과정을 거쳤음 (no denormalizaion)
- 자연어로써, 한국 명칭만을 담은 테이블을 따로 만들어 LN으로 지칭함
- 회원가입과 로그인/로그아웃을 위한 user table 구성
- 서칭 기록을 담은 테이블인 history 테이블을 생성하고, 이를 history_category, history_user로 더욱 세분화함
<br>
![DB Table](https://user-images.githubusercontent.com/29566893/127652463-437588b3-156b-4275-a43b-8d28ca26cd5a.png)

package lee;

import org.hibernate.Transaction;
import org.hibernate.Session;

import java.util.*;
import org.crazyit.app.domain.*;

/**
 * Description:
 * <br/>网站: <a href="http://www.crazyit.org">疯狂Java联盟</a>
 * <br/>Copyright (C), 2001-2016, Yeeku.H.Lee
 * <br/>This program is protected by copyright laws.
 * <br/>Program Name:
 * <br/>Date:
 * @author  Yeeku.H.Lee kongyeeku@163.com
 * @version  1.0
 */
public class PersonManager
{
	public static void main(String[] args)
	{
		PersonManager mgr = new PersonManager();
		mgr.createAndStorePerson();
		HibernateUtil.sessionFactory.close();
	}
	private void createAndStorePerson()
	{
		Session session = HibernateUtil.currentSession();
		Transaction tx = session.beginTransaction();
		// 创建Person对象
		Person person = new Person();
		//为Person对象设置属性
		person.setAge(29);
		//创建一个Map集合
		Map<String , Name> nicks =
			new HashMap<String , Name>();
		// 向List集合里放入Name对象
		person.getNicks().add(new Name("Wawa" , "Wawa"));
		person.getNicks().add(new Name("Yeeku" , "Lee"));
		// 向List集合里放入Score对象
		person.getScores().put("语文" , new Score("良好" , 85));
		person.getScores().put("数学" , new Score("优秀" , 92));
		session.save(person);
		tx.commit();
		HibernateUtil.closeSession();
	}
}